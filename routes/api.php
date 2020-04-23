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

Route::post('/bot-wa', 'WebServiceBotController@listenToReplies');

Route::get('/phone', 'PhoneController@getDataTable');
Route::delete('/phone/delete', 'PhoneController@delete');
Route::get('/response', 'ResponseController@getDataTable');
Route::get('/response/{id}', 'ResponseController@getById');
Route::get('/response/check-code/{code}', 'ResponseController@checkCode');
Route::post('/response/post', 'ResponseController@post');
Route::post('/response/update', 'ResponseController@update');
Route::delete('/response/delete', 'ResponseController@delete');
Route::get('/user', 'UserController@getDataTable');
Route::get('/user/{id}', 'UserController@getById');
Route::get('/user/check-username/{username}', 'UserController@checkUsername');
Route::post('/user/post', 'UserController@post');
Route::post('/user/update', 'UserController@update');
Route::delete('/user/delete', 'UserController@delete');