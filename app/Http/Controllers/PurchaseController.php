<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class PurchaseController extends Controller
{
    // will be changed later for only authenticated user
    public function purchase($albumId)
    {
        $user = Auth::user();

        if (!$user) {
            $user = User::find(1);
        }
        $album = Album::findOrFail($albumId);

        // Attach the album to the user's purchased albums
        $user->albums()->attach($album);

        return response()->json(['message' => 'Album purchased successfully']);
    }

    public function getPurchases()
    {
        $user = User::find(1);
        // Get user's purchased music
        $purchasedAlbums = $user->albums;

        return response()->json(['purchased_albums' => $purchasedAlbums]);
    }
}
