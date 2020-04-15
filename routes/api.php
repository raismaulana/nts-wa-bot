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

// menambahkan route untuk auth
Route::get('/auth','AuthController@all');
Route::get('/auth/{id}','AuthController@show');
Route::post('/auth','AuthController@store');
Route::put('/auth/{id}','AuthController@update');
Route::delete('/auth/{id}','AuthController@delete');

// menambahkan route untuk response
Route::get('/response','ResponseController@all');
Route::get('/response/{id}','ResponseController@show');
Route::post('/response','ResponseController@store');
Route::put('/response/{id}','ResponseController@update');
Route::delete('/response/{id}','ResponseController@delete');

// menambahkan route untuk user
Route::get('/user','UserController@all');
Route::get('/user/{id}','UserController@show');
Route::post('/user','UserController@store');
Route::put('/user/{id}','UserController@update');
Route::delete('/user/{id}','UserController@delete');
