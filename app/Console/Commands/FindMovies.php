<?php

namespace App\Console\Commands;
use App\Pelicula;
use Illuminate\Console\Command;

class FindMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:movie {id : ID de la pelicula}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buscar Peliculas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id=$this->argument('id');
        $pelicula=Pelicula::findOrFail($id);
        echo "pelicula econtrada, ".$pelicula->titulo;
    }
}
