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

        @foreach($arrayPeliculas as $key => $pelicula)
        <div class="col-xs-6 col-sm-4 col-md-3 text-center">

            <a href="{{ route('catalog.show', [$pelicula->id] ) }}">
                <!-- Dos imatges una per si es un enllaç i l'altre per si es una imatge del server -->
                <img src="{{ $pelicula->poster }}" onerror="this.style.display='none'" style="height:200px">
                <img src="{{ asset('img/' . $pelicula->poster) }}" onerror="this.style.display='none'" style="height:200px">

                <h4 style="min-height:45px;margin:5px 0 10px 0">
                    {{ $pelicula->title }}
                </h4>
            </a>

        </div>
        @endforeach

    </div>
@endsection