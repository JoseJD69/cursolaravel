<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Actor;

class ActorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Actor::query();
        $query = $query->withCount('peliculas')->orderBy('apellidos');
        if ($request->display == "all") {
            $query = $query->withTrashed();
        } else if ($request->display == "trash") {
            $query = $query->onlyTrashed();
        }
        $actores = $query->paginate(10);
        return view('panel.actores.index', compact('actores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\GeneroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneroRequest $request)
    {
        try {
            $genero = Genero::create($request->except('idPelicula'));
            $genero->save();
            return redirect('generos')->with('success', 'Genero registrado');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("panel.generos.create");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Genero::withTrashed()->where('idGenero', $id)->forceDelete();
            return redirect('generos')->with('success', 'Género eliminado permanentemente');
        } catch (Exception | QueryException $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }

    public function restore($id)
    {
        try {
            Genero::withTrashed()->where('idGenero', $id)->restore();
            return redirect('generos')->with('success', 'Género restaurado');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            Genero::destroy($id);
            return redirect('generos')->with('success', 'Género enviado a papelera');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }
}
