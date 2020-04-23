<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'AuthController@index')->name('auth')->middleware('guest');
Route::post('/auth/login', 'AuthController@login')->name('login')->middleware('guest');
Route::get('/auth/login', 'AuthController@login')->name('login')->middleware('guest');
Route::get('/auth/logout', 'AuthController@logout')->name('logout')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
