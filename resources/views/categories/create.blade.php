@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
        <div class="card">
            <div class="card-header text-center">
                Afegir Categoria
            </div>
            <div class="card-body" style="padding:30px">
    
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Títol</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
        
                    <div class="form-group">
                        <label for="adult">Per a adults</label>
                        <select name="adult" class="form-control">
                            <option value="no">No</option>
                            <option value="yes">Sí</option>
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="description">Descripció</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
        
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                            Afegir Categoria
                        </button>
                    </div>
                </form>
    
            </div>
        </div>
    </div>
</div>

@endsection