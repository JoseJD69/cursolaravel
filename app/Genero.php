<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    use SoftDeletes;

    protected $primaryKey = "idGenero";
    protected $table = "generos";
    public $timestamps = true;
    public $fillable=['nombre', 'imagen'];

    protected $hidden=['pivot'];

    public function peliculas()
    {
        return $this->belongsToMany('\App\Pelicula', 'peliculas_generos', 'idGenero', 'idPelicula');
    }



}
