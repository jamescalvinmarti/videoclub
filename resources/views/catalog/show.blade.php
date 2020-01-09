@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}  
                </div>
            @endif
            @if(session()->get('warning'))
                <div class="alert alert-warning">
                    {{ session()->get('warning') }}  
                </div>
            @endif
        </div>
    </div>

    <div class="row">

        <div class="col-sm-4">

            <img src="{{ $pelicula->poster }}" alt="{{ $pelicula->title }}">

        </div>
        <div class="col-sm-8">
            <h1>{{ $pelicula->title }}</h1>
            <h3>Año: {{ $pelicula->year }}</h3>
            <h3>Director: {{ $pelicula->director }}</h3>

            <p><b>Resumen:</b> {{ $pelicula->synopsis }} </p>

            @if ($pelicula['rented'])
            <p><b>Estado:</b> Pelicula actualmente disponible </p>
            <a class="btn btn-info" href="{{ route('catalogRent', [$pelicula->id]) }}">Alquilar Pelicula</a>
            @else
            <p><b>Estado:</b> Pelicula actualmente alquilada </p>
                <a class="btn btn-danger" href="{{ route('catalogReturn', [$pelicula->id]) }}">Devolver Pelicula</a>
            @endif
            
            <a class="btn btn-warning" href="{{ route('catalog.edit', [$pelicula->id]) }}">Editar Pelicula</a>
            <a class="btn btn-light" href="{{ action('CatalogController@index') }}">Volver al listado</a>
            {{-- <a class="btn btn-danger" href="{{ route('catalog.destroy', [$pelicula->id]) }}">Eliminar Pelicula</a> --}}

            <form action="{{ route('catalog.destroy' , $pelicula->id)}}" method="POST" style="display: inline-block">
                <input name="_method" type="hidden" value="DELETE">
                {{ csrf_field() }}
            
                <button type="submit" class="btn btn-danger">Eliminar Pelicula</button>
            </form>

        </div>
    </div>
@endsection