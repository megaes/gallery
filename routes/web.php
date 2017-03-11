<?php

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


Auth::routes();

Route::patch('/resource/{resource}', 'HomeController@updateCaption');
Route::post('/delete', 'HomeController@delete');
Route::post('/{album_id}', 'HomeController@get');
Route::get('/', 'HomeController@index');

Route::get('/thumbnails', 'HomeController@thumbnails');

