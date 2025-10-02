<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('artists', ArtistController::class);
Route::apiResource('albums', AlbumController::class);
Route::get('/songs/search', [SongController::class, 'search']);
Route::apiResource('songs', SongController::class)->where(['song' => '[0-9]+']);


// Get artist details with albums
Route::get('/artists/{id}', [ArtistController::class, 'show']);
// Get songs by album
Route::get('/albums/{id}/songs', [AlbumController::class, 'songs']);
Route::get('/albums/name/{name}/songs', [AlbumController::class, 'songsByName']);
// Search for songs