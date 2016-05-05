<?php

//Route::auth();

//Route::get('/home', 'HomeController@index');

/**
 * API
 */
// Route::group(['prefix' => 'api/v1'], function () {
//
//   // Auth
//   Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
//   Route::post('authenticate', 'AuthenticateController@authenticate');
//
//   // Users
//   Route::group(['prefix' => 'users'], function () {
//
//    Route::get('/', 'UserController@index');
//
//   });
//
// });

// Route to create a new role
Route::post('role', 'AuthenticateController@createRole');
// Route to create a new permission
Route::post('permission', 'AuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'AuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'AuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'AuthenticateController@index');
});

// Authentication route
Route::post('authenticate', 'AuthenticateController@authenticate');

//Route::post('api/v1/auth/login', ['uses' => ''])
//Route::get('api/resources', ['uses' => 'ResourceController@index','middleware'=>'simpleauth']);
//Route::post('api/resources', ['uses' => 'ResourceController@store','middleware'=>'simpleauth']);
