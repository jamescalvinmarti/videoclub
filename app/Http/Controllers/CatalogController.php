<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Category;
use App\Review;
use Illuminate\Support\Facades\Auth;

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
        $categories = Category::all();
        return view('catalog.create', compact('categories'));
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        $categories = Category::all();
        return view('catalog.edit', compact('id', 'movie', 'categories'));
    }

    public function store(Request $request)
    {
        $movie = new Movie;
        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->poster = $request['poster'];
        $movie->synopsis = $request['synopsis'];
        $movie->category_id = $request['category'];
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
        $movie->category_id = $request['category'];
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

    public function reviewCreate(Request $request)
    {
        $movie_id = $request['movie'];
        $review = new Review;
        $review->title = $request['title'];
        $review->stars = $request['stars'];
        $review->review = $request['review'];
        $review->movie_id = $movie_id;
        $review->user_id = Auth::id();

        $review->save();

        return redirect('/catalog/' . $movie_id)->with('success', 'Comentari creat correctament');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        if ($search == '') {
            return redirect('/catalog');
        }

        $arrayPeliculas = Movie::where(
            'title',
            'like',
            '%' . $search . '%'
        )->orWhere(
            'director',
            'like',
            '%' . $search . '%'
        )->get();

        if (count($arrayPeliculas) == 0) {
            return redirect('/catalog')->with('warning', 'No hi ha hagut cap coincidència');
        }

        return view('catalog.index', compact('arrayPeliculas'));
    }
}
