@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Información del genero <a class="btn btn-primary" href="{{url('generos')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Nombre:</b> {{$generos->nombre}}</li>
                            
                            <li class="list-group-item"><b>Imagen:</b> 
                                @if($generos->imagen == null)
                                    -
                                @else
                                    <img src="{{\Storage::url($generos->imagen)}}" style="max-height:300px;">
                                @endif
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
