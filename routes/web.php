<?php

use Illuminate\Http\Request;

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

Route::get('/', function() {
  if (Auth::check()) {
      return File::get(public_path() . '/static/teams/index.html');
  } else {
    return File::get(public_path() . '/static/front-page/index.html');
  }
});

Route::get('/login', function() {
  return File::get(public_path() . '/static/login/index.html');
})->middleware('guest');


Route::get('/resources', function() {
  return File::get(public_path() . '/static/resource-list/index.html');
})->middleware('guest');

Route::get('/category/{slug}', function() {
  return File::get(public_path() . '/static/resource-list/index.html');
})->middleware('guest');

Route::get('/resources/{id}/{slug}', function() {
  return File::get(public_path() . '/static/resource/index.html');
})->middleware('guest');

// Get a file
Route::get('/resources/{id}/file/{docId}', 'ResourceController@file');

Auth::routes();
