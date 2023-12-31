<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class PurchaseController extends Controller
{
    public function purchase($albumId)
    {
        $album = Album::findOrFail($albumId);

        Auth::User()->albums()->attach($album);

        return response()->json(['message' => 'Album purchased successfully']);
    }

    public function getPurchases()
    {
        $purchasedAlbums = Auth::user()->albums()
            ->with(['songs.artist', 'artist'])
            ->get();

        return response()->json(['purchased_albums' => $purchasedAlbums]);
    }



    public function search(Request $request)
    {
        $user_id = auth()->id();
        $search = $request->input('search');
        $sort = $request->input('sort');

        $query = Album::query()->with('artist')
            ->join('user_albums', 'albums.id', '=', 'user_albums.album_id')
            ->where('user_albums.user_id', $user_id);

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($sort) {
            if ($sort === 'artist.name') {
                $query->join('artists', 'albums.artist_id', '=', 'artists.id')
                    ->orderBy('artists.name');
            } else {
                $query->orderBy($sort);
            }
        }

        $result = $query->get();

        return response()->json($result);
    }





}
