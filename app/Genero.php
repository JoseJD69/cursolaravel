<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\GeneroNotification;
use Notification;
use Auth;
use OneSignal;

class Genero extends Model
{
    use SoftDeletes;

    protected $primaryKey = "idGenero";
    protected $table = "generos";
    public $timestamps = true;
    public $fillable = ['nombre', 'imagen'];

    protected $hidden = ['pivot'];

    public function peliculas()
    {
        return $this->belongsToMany('\App\Pelicula', 'peliculas_generos', 'idGenero', 'idPelicula');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($genero) { // before delete() method call this
            $route=route('generos.show',$genero->idGenero);
            OneSignal::sendNotificationToAll("Se envio a la papelera " . $genero->nombre . " a las " . $genero->deleted_at, $route, null, null, null);
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero));
        });
        static::restored(function ($genero) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero));
        });
    }


}
