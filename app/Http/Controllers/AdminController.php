<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;

class AdminController extends Controller
{
    public function getArtists()
    {
        $artist = Artist::all();
        return response()->json($artist);
    }
    public function getAlbums()
    {
        $album = Album::all();
        return response()->json($album);
    }
    public function getAlbumsByArtist($artistId)
    {
        $albums = Album::where('artist_id', $artistId)->get();

        if ($albums->isEmpty()) {
            return response()->json(['error' => 'No albums  found for this artist'], 404);
        }
        return response()->json($albums);
    }
    public function getSongsByALbum($albumId)
    {
        $songs = Song::where('album_id', $albumId)->get();

        if ($songs->isEmpty()) {
            return response()->json(['error' => 'No songs  found in this album'], 404);
        }
        return response()->json($songs);
    }
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

    public function addAlbum(Request $request, $artist_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artwork' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre' => 'required|string|max:255',
        ]);

        $artworkPath = $request->file('artwork')->store('albums/artwork', 'public');

        $album = Album::create([
            'title' => $request->input('title'),
            'artist_id' => $artist_id,
            'artwork' => $artworkPath,
            'genre' => $request->input('genre'),
        ]);

        return response()->json(['album' => $album, 'message' => 'Album added successfully']);
    }

    public function addSong(Request $request, $album_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'audio' => 'required|mimes:audio/mpeg,mpga,mp3',
        ]);
        $audio = $request->file('audio');
        $audioPath = 'audio/' . $audio->hashName();
        $audio->storeAs('public/audio', $audio->hashName());
        $song = Song::create([
            'title' => $request->input('title'),
            'album_id' => $album_id,
            'audio' => $audioPath,
        ]);

        return response()->json(['song' => $song, 'message' => 'Song added successfully']);
    }
}
