<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUserData']);

// Music Management
Route::get('/search', [MusicController::class, 'search']);
Route::get('/albums', [MusicController::class, 'getAlbums']);

// Artist (if needed)
Route::get('/artists', [ArtistController::class, 'getArtists']);
Route::get('/artists/{artistId}/albums', [ArtistController::class, 'getAlbumsByArtist']);

Route::get('/albums/{albumId}/songs', [MusicController::class, 'findSongByAlbum']);
Route::post('/purchase/{albumId}', [PurchaseController::class, 'purchase']);
Route::get('/purchases', [PurchaseController::class, 'getPurchases']);

// Admin Features
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/artists', [AdminController::class, 'addArtist']);
    Route::post('/admin/albums', [AdminController::class, 'addAlbum']);
    Route::post('/admin/songs', [AdminController::class, 'addSong']);
});
