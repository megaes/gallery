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

Route::patch('/resources/{resource}', 'ResourceController@updateCaption');
Route::patch('/resources', 'ResourceController@updateTags');
Route::post('/resources/delete', 'ResourceController@delete');

Route::patch('/albums/{id}', 'AlbumController@update');
Route::post('/albums/{id}/photo', 'AlbumController@uploadPhoto');
Route::post('/albums/{id}/video', 'AlbumController@uploadVideo');
Route::delete('/albums/{album}', 'AlbumController@delete');
Route::get('/albums/{album}/resources', 'AlbumController@getResources');
Route::get('/albums/{album}/tags', 'AlbumController@getTags');
Route::get('/albums', 'AlbumController@index');
Route::post('/albums/create', 'AlbumController@create');

Route::get('/', 'HomeController@index');

