<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/token', 'ConnexionController@auth');

Route::middleware('auth:sanctum')->post('/cards', 'ConnexionController@getCards');

Route::middleware('auth:sanctum')->get('/cards/{card_id}', 'ConnexionController@singleCard');

Route::middleware('auth:sanctum')->post('/transaction', 'ConnexionController@addTransaction');

Route::middleware('auth:sanctum')->post('/logout', 'ConnexionController@logout');