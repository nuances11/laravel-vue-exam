<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Requests\StoreAlbum;
use App\Http\Requests\UpdateAlbum;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $albums = [];
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $albums = Album::with('user')
                ->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                })
                ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                ->get();
        } else {
            $albums =
                Album::with('user')->get();
        }

        return response()->json($albums);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbum $request)
    {
        Album::insert($request->only([
            'title',
            'user_id'
        ]));

        return response()->json(
            [
                'message' => 'Album added',
                'success' => true
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return response()->json($album);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbum $request, Album $album)
    {

        $album->update($request->only([
            'title',
            'user_id'
        ]));

        return response()->json(
            [
                'message' => 'Album updated',
                'success' => true
            ],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return response()->json(
            [
                'message' => 'Album deleted',
                'success' => true
            ],
            200
        );
    }
}
