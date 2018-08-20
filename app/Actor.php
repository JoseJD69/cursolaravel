<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $primaryKey = "idActor";
    protected $table = "actores";
    public $fillable=['nombres','apellidos','pais'];
    public $timestamps = true;

    public function peliculas()
    {
        return $this->belongsToMany('\App\Pelicula', 'peliculas_actores', 'idActor', 'idPelicula');
    }
}
