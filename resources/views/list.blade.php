@extends('layouts.master')

@section('content')
    <h1>Pel·lícules millor puntuades:</h1>

    <ol id="movies-list">
        @foreach ($movies as $movie)
            <li>
                <img src="{{ $movie->poster }}" style="height:200px;"/>
                <h3><a href="{{ route('catalog.show', [$movie->id]) }}">{{ $movie->title }}</a></h3>
                <h5>{{ $movie->reviews()->avg('stars') }}</h5>
            </li>
        @endforeach
    </ol>

@endsection