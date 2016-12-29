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
    return view('public.base', [
      'appName' => 'teams',
      'pageName' => 'Equipos'
    ]);
  } else {
    return view('public.base', [
      'appName' => 'front-page',
      'pageName' => 'Recursos para el trabajo con jóvenes y adolescentes'
    ]);
  }
});

Route::get('/resources', function() {
  return view('public.base', [
    'appName' => 'resource-list',
    'pageName' => $resource->title
  ]);
});

Route::get('/category/{category}', function(App\Category $category) {
  return view('public.base', [
    'appName' => 'resource-list',
    'pageName' => $category->label
  ]);
});

Route::get('/resources/{resource}/{slug}', 'Web\ResourceController@show');

// Get a file
Route::get('/resources/{id}/file/{docId}', 'Api\ResourceController@file')
  ->middleware('auth');

Auth::routes();
