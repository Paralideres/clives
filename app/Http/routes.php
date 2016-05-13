<?php

//Route::get('/home', 'HomeController@index');

/**
 * API
 */

// Route to create a new role
Route::post('role', 'AuthenticateController@createRole');
// Route to create a new permission
Route::post('permission', 'AuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'AuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'AuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'api'], function()
{

    Route::group(['prefix' => 'users'], function() {

      // User List
      Route::get('/', 'UserController@index');

      // Create User
      Route::post('/', 'UserController@store');

      //User Actions
      Route::group(['prefix' => '/{user_id}'], function($userId) {

        // Get User
        Route::get('/', 'UserController@show');

        // Update User
        Route::put('/', 'UserController@update');

        // Delete User
        Route::delete('/', 'UserController@delete');

        // Get User Profile
        Route::get('/profile', 'UserController@getProfile');

        // Update User Profile
        Route::put('/profile', 'UserController@updateProfile');
      });

    });

});

// Authentication route
Route::post('authenticate', 'AuthenticateController@authenticate');
