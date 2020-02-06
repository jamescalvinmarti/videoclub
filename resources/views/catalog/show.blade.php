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

            <div class="reviews">
                <h4>Comentaris</h4>
    
                @foreach($pelicula->reviews as $review)
                    <div class="comment">
                        <p class="title">{{ $review->title }}</p>

                        @if ($review->stars == 1)
                            <p>{{ $review->stars }} estrella</p>
                        @else
                            <p>{{ $review->stars }} estrelles</p>
                        @endif

                        <p>{{ $review->review }}</p>
                        <span>{{ $review->created_at->format('d-m-Y') }} - {{ ucfirst($review->user->name) }}</span>
    
                    </div>
                @endforeach
            </div>

            <form action="{{ route('reviewCreate') }}" method="POST" class="review-form">
                @csrf
                <div class="form-group">
                    <label for="title">Títol:</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="form-group">
                    <label for="stars">Valoració</label>
                    <select name="stars" class="form-control">
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrelles</option>
                        <option value="3">3 estrelles</option>
                        <option value="4">4 estrelles</option>
                        <option value="5">5 estrelles</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="review">Comentari:</label>
                    <textarea class="form-control" name="review" rows="5" placeholder="Dona'ns la teva opinió"></textarea>
                </div>
    
                <input type="hidden" name="movie" value="{{ $pelicula->id }}">

                <input type="submit" class="btn btn-success" value="Enviar">
            </form>
        </div>

    </div>
@endsection