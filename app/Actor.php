<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Actor extends Model
{
    use SoftDeletes;
    protected $primaryKey = "idActor";
    protected $table = "actores";
    public $fillable=['nombres','apellidos','pais'];
    public $timestamps = true;

    public function peliculas()
    {
        return $this->belongsToMany('\App\Pelicula', 'peliculas_actores', 'idActor', 'idPelicula');
    }
}
