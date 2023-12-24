<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;

class AdminController extends Controller
{
    public function addArtist(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist = Artist::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['artist' => $artist, 'message' => 'Artist added successfully']);
    }

    public function addAlbum(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'artwork' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre' => 'required|string|max:255',
        ]);

        $artworkPath = $request->file('artwork')->store('albums/artwork', 'public');

        $album = Album::create([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist_id'),
            'artwork' => $artworkPath,
            'genre' => $request->input('genre'),
        ]);

        return response()->json(['album' => $album, 'message' => 'Album added successfully']);
    }

    public function addSong(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'album_id' => 'required|exists:albums,id',
            'audio' => 'required|mimes:mp3|max:20480',
        ]);

        $audioPath = $request->file('audio')->store('songs/audio', 'public');

        $song = Song::create([
            'title' => $request->input('title'),
            'album_id' => $request->input('album_id'),
            'audio' => $audioPath,
        ]);

        return response()->json(['song' => $song, 'message' => 'Song added successfully']);
    }
}
