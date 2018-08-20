@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Nuevo Genero <a class="btn btn-primary" href="{{url('generos')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        @include('includes.messages')
                        {!! Form::open(['url' => 'generos','files'=>'true']) !!}
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Título del Genero</label>
                                <div class="col-sm-10">
                                    <input required type="text" class="form-control" id="nombre" name="nombre" value="{{old('nombre')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="imagen" name="imagen">
                                </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-10">
                                      <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
