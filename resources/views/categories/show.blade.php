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

    <div class="col-sm-8">
        <h1>{{ $category->title }}</h1>

        @if($category->adult == 0)
            <p><b>Per a adults:</b> <span class="badge badge-success">No</span></p>
        @else
            <p><b>Per a adults:</b> <span class="badge badge-danger">Sí</span></p>
        @endif

        <p><b>Descripció:</b> {{ $category->description }} </p>

        <button class="btn btn-primary"><a href="{{ route('category.edit', [$category->id]) }}">Editar</a></button>
        <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal">Eliminar Categoria</button>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Eliminar {{ $category->name }} </h5>
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

@endsection