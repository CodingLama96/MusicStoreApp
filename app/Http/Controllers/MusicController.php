<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;

class MusicController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $songs = Song::where('title', 'like', '%' . $query . '%')->get();

        return response()->json(['songs' => $songs]);
    }
    public function getAlbums()
    {
        $albums = Album::all();
        return response()->json($albums);
    }
    public function findSongByAlbum($albumId)
    {
        $songs = Song::where('album_id', $albumId)->get();

        if ($songs->isEmpty()) {
            return response()->json(['error' => 'Songs not found for the album'], 404);
        }

        return response()->json($songs);
    }
}
