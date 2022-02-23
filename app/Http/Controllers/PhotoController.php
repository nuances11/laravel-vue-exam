<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $photos = [];
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $albums = Photo::with('album')
                ->whereHas('album', function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', '%' . $keyword . '%');
                })
                ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                ->get();
        } else {
            $albums =
                Photo::with('album')->get();
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
    public function store(StorePhoto $request)
    {

        Photo::insert($request->only([
            'album_id',
            'title',
            'url',
            'thumbnailUrl'
        ]));

        return response()->json(
            [
                'message' => 'Photo added',
                'success' => true
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return response()->json($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {

        $photo->update($request->only([
            'album_id',
            'title',
            'url',
            'thumbnailUrl'
        ]));

        return response()->json(
            [
                'message' => 'Photo updated',
                'success' => true
            ],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json(
            [
                'message' => 'Photo deleted',
                'success' => true
            ],
            200
        );
    }
}
