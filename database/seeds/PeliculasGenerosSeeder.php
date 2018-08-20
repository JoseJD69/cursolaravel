<?php

use Illuminate\Database\Seeder;

class PeliculasGenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*  factory(App\Pelicula::class, 10)->create()->each(function ($u) {
            $u->generos()->save(factory(App\Genero::class)->make());
        });*/
       factory(App\Pelicula::class, 10)->create()->each(function ($u) {
         $u->generos()->attach(factory(App\Genero::class,2)->create());
       });
    }
}
