<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PurchaseController;
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


// Music Management
Route::get('/search', [MusicController::class, 'search']);
Route::get('/albums/{albumId}/songs', [MusicController::class, 'findSongByAlbum']);
Route::post('/purchase/{albumId}', [PurchaseController::class, 'purchase']);
Route::get('/purchases', [PurchaseController::class, 'getPurchases']);

