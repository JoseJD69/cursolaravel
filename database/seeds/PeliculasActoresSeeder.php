<?php

use Illuminate\Database\Seeder;

class PeliculasActoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pelicula::class, 5)->create()->each(function ($u) {
            $u->actores()->attach(factory(App\Actor::class,2)->create());
          });
    }
}
