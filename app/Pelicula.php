<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\PeliculaNotification;
use Notification;
use Input;
use DB;
use Auth;
use Storage;

class Pelicula extends Model
{
    protected $primaryKey = "idPelicula";
    protected $table = "peliculas";
    public $timestamps = true;
    public $fillable = ['titulo', 'duracion', 'anio', 'imagen'];
    //CONST CREATED_AT="fecha_registro";

    protected $hidden = ['pivot'];

    public function generos()
    {
        return $this->belongsToMany('\App\Genero', 'peliculas_generos', 'idPelicula', 'idGenero');
    }
    public function actores()
    {
        return $this->belongsToMany('\App\Actor', 'peliculas_actores', 'idPelicula', 'idActor');
    }

    public function scopeCortas($query)
    {
        return $query->where('duracion', '<', '120');
    }

    public function scopeActuales($query)
    {
        return $query->where('anio', date('Y'));
    }
    public function scopeAgrupar($query)
    {
        return $query->select('anio', 'duracion', DB::raw('count(*) as registros'))->groupBy('anio', 'duracion');
    }
    public static function findGenero($array, $idGenero)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idGenero) {
                    return true;
                }
            }
        }
        return false;
    }
    public static function findActor($array, $idActor)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idActor) {
                    return true;
                }
            }
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pelicula) { // before delete() method call this
            $pelicula->generos()->detach();
            $pelicula->actores()->detach();

            if ($pelicula->imagen != null) {
                Storage::delete($pelicula->imagen);
            }
        });
        static::creating(function ($pelicula) { // before delet
            if (Input::hasFile('imagen') && $pelicula->imagen != null) {
                $image = Input::file('imagen');
                $pelicula->imagen = $image->store('public/peliculas');
            }
        });
        static::created(function ($pelicula) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new PeliculaNotification($pelicula));

        });
        static::updated(function ($pelicula) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new PeliculaNotification($pelicula,true));

        });
    }

}
