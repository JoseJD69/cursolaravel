<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests\ActorRequest;
use App\Notifications\GeneroNotification;
use Notification;
use Auth;


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
     * @param  \Illuminate\Http\ActorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        try {
            $actor = Actor::create($request->except('idPelicula'));
            $actor->save();
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
        return view("panel.actores.create");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actores=Actor::findOrFail($id);
        return view("panel.actores.show", compact('actores'));
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
            Actor::withTrashed()->where('adActor', $id)->forceDelete();
            return redirect('actores')->with('success', 'Actor eliminado permanentemente');
        } catch (Exception | QueryException $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }

    public function restore($id)
    {
        try {
            Actor::withTrashed()->where('idActor', $id)->restore();
            return redirect('generos')->with('success', 'Actor restaurado');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            Actor::destroy($id);
            return redirect('actores')->with('success', 'Actor enviado a papelera');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }
}
