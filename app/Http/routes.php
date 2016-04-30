<?php

//Route::auth();

//Route::get('/home', 'HomeController@index');

/**
 * API
 */
Route::group(['prefix' => 'api/v1'], function () {

  // Auth
  Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
  Route::post('authenticate', 'AuthenticateController@authenticate');

});

//Route::post('api/v1/auth/login', ['uses' => ''])
//Route::get('api/resources', ['uses' => 'ResourceController@index','middleware'=>'simpleauth']);
//Route::post('api/resources', ['uses' => 'ResourceController@store','middleware'=>'simpleauth']);
