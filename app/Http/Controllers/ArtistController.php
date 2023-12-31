<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function getArtists()
    {
        $artists = Artist::all();

        return response()->json(['artists' => $artists]);
    }

    public function getAlbumsByArtist($artistId)
    {
        $artist = Artist::findOrFail($artistId);
        $albums = $artist->albums;

        return response()->json(['albums' => $albums]);
    }
}


