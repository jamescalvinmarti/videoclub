@extends('layouts.master')

@section('content')
<div class="row" style="margin-top:40px">
        <div class="offset-md-3 col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Modificar película
                </div>

                <div class="card-body" style="padding:30px">
        
                    <form action="{{ route('catalog.update', [$id]) }}" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf
            
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $movie->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Categoria</label>
                            <select name="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $movie->category->id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="form-group">
                            <label for="year">Año</label>
                            <input type="number" name="year" id="year" class="form-control" value="{{ $movie->year }}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="director">Director</label>
                            <input type="text" name="director" id="director" class="form-control" value="{{ $movie->director }}" required>   
                        </div>
            
                        <div class="form-group">
                            <label for="poster">Poster</label>
                            <input type="file" name="poster" id="poster" class="form-control">   
                        </div>

                        <div class="form-group">
                            <label for="synopsis">Resumen</label>
                            <textarea name="synopsis" id="synopsis" class="form-control" rows="3" required>{{ $movie->synopsis }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="trailer">Trailer</label>
                            <input type="text" name="trailer" class="form-control" required value="{{ $movie->trailer }}">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                                Modificar película
                            </button>
                        </div>
                    </form>
        
                </div>
            </div>
        </div>
    </div>

@endsection