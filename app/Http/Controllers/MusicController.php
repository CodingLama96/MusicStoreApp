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
    public function findSongByAlbum($albumId)
    {
        $song = Song::find($albumId);
        if (!$song) {
            return response()->json(['error' => 'Song not found'], 404);
        }

        return response()->json($song);
    }
}
