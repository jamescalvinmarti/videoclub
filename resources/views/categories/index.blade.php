@extends('layouts.master')

@section('content')
    <h1>Llistat de categories</h1>

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

    <button id="add-category" class="btn btn-success"><a href="{{ route('category.create') }}">Afegir Categoria</a></button>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Títol</th>
            <th>Descripció</th>
            <th>Només per adults</th>
            <th>Accions</th>
        </tr>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->title }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    @if($category->adult == 0)
                        <span class="badge badge-success">No</span>
                    @else
                        <span class="badge badge-danger">Sí</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-info"><a href="{{ route('category.show', $category->id) }}">Mostrar</a></button>
                    <button class="btn btn-primary"><a href="{{ route('category.edit', $category->id) }}">Editar</a></button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#modal{{$category->id}}">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $categories->links() }}

    @foreach ($categories as $category)
        <!-- Modal -->
        <div class="modal fade" id="modal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel{{ $category->id }}">Eliminar {{ $category->title }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Estàs a punt d'eliminar la categoria {{ $category->title }}. Estàs segur?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel·lar</button>
                        <form action="{{ route('category.destroy', [$category->id]) }}" id='modal-delete-form' method='POST'>
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="DELETE">

                            <button type="submit" class="btn btn-danger delete-btn">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection