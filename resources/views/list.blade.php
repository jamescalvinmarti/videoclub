@extends('layouts.master')

@section('content')
    <h1>Pel·lícules millor puntuades:</h1>

    <ol id="movies-list">
        @foreach ($movies as $movie)
            <li>
                <!-- Dos imatges una per si es un enllaç i l'altre per si es una imatge del server -->
                <img src="{{ $movie->poster }}" onerror="this.style.display='none'" style="height:200px">
                <img src="{{ asset('img/' . $movie->poster) }}" onerror="this.style.display='none'" style="height:200px">

                <h3><a href="{{ route('catalog.show', [$movie->id]) }}">{{ $movie->title }}</a></h3>
                
                <!-- Nota total de la pel·lícula -->
                <h5>{{ $movie->reviews()->avg('stars') }}</h5>
            </li>
        @endforeach
    </ol>

@endsection