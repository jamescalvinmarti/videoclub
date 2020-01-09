<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class CatalogController extends Controller
{
    public function index()
    {
        $arrayPeliculas = Movie::all();
        return view('catalog.index', compact('arrayPeliculas'));
    }

    public function show($id)
    {
        $pelicula = Movie::find($id);
        return view('catalog.show', compact('pelicula'));
    }

    public function create()
    {
        return view('catalog.create');
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('catalog.edit', compact('id', 'movie'));
    }

    public function store(Request $request)
    {
        $movie = new Movie;
        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->poster = $request['poster'];
        $movie->synopsis = $request['synopsis'];
        $movie->save();

        return redirect('/catalog')->with('success', 'Pelicula creada correctament');
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->poster = $request['poster'];
        $movie->synopsis = $request['synopsis'];
        $movie->save();

        return redirect('/catalog/' . $id)->with('success', 'Pelicula editada correctament');
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie->delete();

        return redirect()->route('catalog.index')->with('warning', 'Pelicula eliminada correctament');
    }

    public function rent($id)
    {
        $movie = Movie::find($id);
        $movie->rented = 0;
        $movie->save();

        return redirect('/catalog/' . $id)->with('success', 'Pelicula llogada correctament');
    }

    public function return($id)
    {
        $movie = Movie::find($id);
        $movie->rented = 1;
        $movie->save();

        return redirect('/catalog/' . $id)->with('success', 'Pelicula tornada correctament');
    }
}
