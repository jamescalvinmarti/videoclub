<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Category;
use App\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;

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
        $this->validate($request, [
            'title' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'director' => ['required', 'string'],
            'poster' => ['required', 'image'],
            'synopsis' => ['required', 'string'],
            'category' => ['required', 'integer'],
            'trailer' => ['required', 'string']
        ]);

        $movie = new Movie;

        // agafar la imatge del formulari
        $image = $request['poster'];
        // directori on es guardara la imatge
        $original_path = public_path() . '/img';
        // nom que tindrà la imatge. timestamp més nom original de la imatge
        $filename = time() . $image->getClientOriginalName();
        // moure la imatge al directori
        $image->move($original_path, $filename);
        // definir la imatge de la pelicula
        $movie->poster = $filename;

        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->synopsis = $request['synopsis'];
        $movie->category_id = $request['category'];
        $movie->trailer = $request['trailer'];
        $movie->save();

        return redirect('/catalog')->with('success', 'Pelicula creada correctament');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'director' => ['required', 'string'],
            'poster' => ['image'],
            'synopsis' => ['required', 'string'],
            'category' => ['required', 'integer'],
            'trailer' => ['required', 'string']
        ]);

        $movie = Movie::find($id);

        // si el camp poster conté una imatge eliminar imatge existent i substituir-la amb la nova
        // sinó es manté la que ja tenia
        if ($request['poster']) {
            // ubicar la imatge
            $poster = public_path() . '/img/' . $movie->poster;
            // eliminar la imatge antiga si existeix
            if (File::exists($poster)) {
                File::delete($poster);
            }

            $image = $request['poster'];
            // directori on es guardara la imatge
            $original_path = public_path() . '/img';
            // nom que tindrà la imatge. timestamp més nom original de la imatge
            $filename = time() . $image->getClientOriginalName();
            // moure la imatge al directori
            $image->move($original_path, $filename);
            // definir la imatge de la pelicula
            $movie->poster = $filename;
        }

        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->synopsis = $request['synopsis'];
        $movie->category_id = $request['category'];
        $movie->trailer = $request['trailer'];
        $movie->save();

        return redirect('/catalog/' . $id)->with('success', 'Pelicula editada correctament');
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);

        // agafar la imatge de la pel·lícula
        $poster = public_path() . '/img/' . $movie->poster;
        // eliminar imatge si existeix
        if (File::exists($poster)) {
            File::delete($poster);
        }

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
        $this->validate($request, [
            'title' => ['required', 'string'],
            'stars' => ['required', 'integer'],
            'review' => ['required', 'string']
        ]);

        // movie es un input hidden del formulari on passo l'id de la pelicula
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
        // paraula o frase que l'usuari busca
        $search = $request['search'];

        // si no ha escrit res redireccionar a la pàgina principal
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

        // si no hi han resultats redireccionar a la pàgina principal amb un avís
        if (count($arrayPeliculas) == 0) {
            return redirect('/catalog')->with('warning', 'No hi ha hagut cap coincidència');
        }

        return view('catalog.index', compact('arrayPeliculas'));
    }

    public function list()
    {
        // llista de les pel·lícules millor puntuades
        $movies = Movie::leftJoin('reviews', 'reviews.movie_id', '=', 'movies.id')
            ->select(array(
                'movies.*',
                DB::raw('AVG(stars) as reviews_average')
            ))
            ->groupBy('id')
            ->orderBy('reviews_average', 'DESC')
            ->limit(10)
            ->get();

        $points = '';

        return view('list', compact('movies'));
    }
}
