<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class APICatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Movie::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movie = new Movie;
        if ($request['title']) {
            $movie->title = $request['title'];
        } else {
            $movie->title = '';
        }

        if ($request['year']) {
            $movie->year = $request['year'];
        } else {
            $movie->year = 0;
        }

        if ($request['director']) {
            $movie->director = $request['director'];
        } else {
            $movie->director = '';
        }

        if ($request['poster']) {
            $movie->poster = $request['poster'];
        } else {
            $movie->poster = '';
        }

        if ($request['synopsis']) {
            $movie->synopsis = $request['synopsis'];
        } else {
            $movie->synopsis = '';
        }
        $movie->save();

        return response()->json([
            'error' => false,
            'msg' => 'La película se ha creado correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Movie::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        if ($request['title']) {
            $movie->title = $request['title'];
        }

        if ($request['year']) {
            $movie->year = $request['year'];
        }

        if ($request['director']) {
            $movie->director = $request['director'];
        }

        if ($request['poster']) {
            $movie->poster = $request['poster'];
        }

        if ($request['synopsis']) {
            $movie->synopsis = $request['synopsis'];
        }

        $movie->save();

        return response()->json([
            'error' => false,
            'msg' => 'La película se ha editado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return response()->json([
            'error' => false,
            'msg' => 'La película se ha eliminado correctamente'
        ]);
    }

    public function putRent($id)
    {
        $m = Movie::findOrFail($id);
        $m->rented = 0;
        $m->save();
        return response()->json([
            'error' => false,
            'msg' => 'La película se ha marcado como alquilada'
        ]);
    }

    public function putReturn($id)
    {
        $m = Movie::findOrFail($id);
        $m->rented = 1;
        $m->save();
        return response()->json([
            'error' => false,
            'msg' => 'La película se ha marcado como devuelta'
        ]);
    }
}
