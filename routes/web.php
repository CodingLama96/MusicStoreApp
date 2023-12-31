<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;


Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
});

Route::get('/user/dashboard', function () {
    return view('welcome');
});

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUserData']);
Route::post('/logout', [AuthController::class, 'logout']);

// Music Management
Route::get('/search', [MusicController::class, 'search']);
Route::get('/albums', [MusicController::class, 'getAlbums']);
Route::get('/albums/{albumId}/songs', [MusicController::class, 'findSongByAlbum']);
// Artist (if needed)
Route::get('/artists', [ArtistController::class, 'getArtists']);
Route::get('/artists/{artistId}/albums', [ArtistController::class, 'getAlbumsByArtist']);

//Purchase Management
Route::post('/purchase/{albumId}', [PurchaseController::class, 'purchase']);
Route::get('/purchases', [PurchaseController::class, 'getPurchases']);
Route::get('/purchases/search', [PurchaseController::class, 'search']);


// Admin route
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/artists', [AdminController::class, 'getArtists']);
    Route::get('/admin/albums', [AdminController::class, 'getAlbums']);
    Route::get('admin/albums/{artistId}', [AdminController::class, 'getAlbumsByArtist']);
    Route::get('admin/songs/{albumId}', [AdminController::class, 'getSongsByALbum']);
    Route::post('/admin/artists', [AdminController::class, 'addArtist']);
    Route::post('/admin/addAlbum/{artistId}', [AdminController::class, 'addAlbum']);
    Route::post('/admin/songs/{albumId}', [AdminController::class, 'addSong']);
    Route::get('/admin/dashboard', function () {
        return view('welcome');
    });
    Route::get('/admin/addArtist', function () {
        return view('welcome');
    });
    Route::get('/admin/addAlbum/{artistId}', function () {
        return view('welcome');
    });
    Route::get('/admin/addSong/{albumId}', function () {
        return view('welcome');
    });
});
