<?php

use Illuminate\Http\Request;

/**
 * API
 */

//User Actions
Route::group(['prefix' => 'account'], function() {

  // Get logged user
  Route::get('/', 'Api\UserController@currentUser');

  // Authentication route
  Route::post('login', 'Api\AuthenticateController@authenticate');

  // Clear cookie route
  Route::post('logout', 'Api\AuthenticateController@clearCookie');

  // Password reset link request routes...
  Route::post('password/email', 'Auth\PasswordController@postEmail');

  // Password reset routes...
  Route::post('password/reset', 'Auth\PasswordController@postReset');
});


// Route to create a new role
Route::post('role', 'Api\RolesController@createRole');

// Route to create a new permission
Route::post('permission', 'Api\RolesController@createPermission');

// Route to assign role to user
Route::post('assign-role', 'Api\RolesController@assignRole');

// Route to attache permission to a role
Route::post('attach-permission', 'Api\RolesController@attachPermission');


//User Actions
Route::group(['prefix' => 'users'], function() {

    // List Users
    Route::get('/', 'Api\UserController@index');

    // Create User
    Route::post('/', 'Api\UserController@store');

    // User Methods
    Route::group(['prefix' => '{id}'], function() {

        // Show User
        Route::get('/', 'Api\UserController@show');

        // Update User
        Route::put('/', 'Api\UserController@update');

        // Delete User
        Route::delete('/', 'Api\UserController@delete');

        // Get User Profile
        Route::get('profile', 'Api\UserController@getProfile');

        // Update user password
        Route::post('password/reset', 'Auth\PasswordController@postReset');

        // Update User Profile
        Route::put('profile', 'Api\UserController@updateProfile');

        // Update User Profile Image
        Route::post('profile/image', 'Api\UserController@updateImage');

        // Delete User Profile Image
        Route::delete('profile/image', 'Api\UserController@deleteImage');
    });
});

// Resources
Route::group(['prefix' => 'resources'], function() {

    // List Resource
    Route::get('/', 'Api\ResourceController@index');

    // Create Resource
    Route::post('/', 'Api\ResourceController@create');

    Route::group(['prefix' => '{id}'], function() {

      // Show Resource
      Route::get('/', 'Api\ResourceController@show');

      // Update Resource
      Route::put('/', 'Api\ResourceController@update');

      // Delete Resource
      Route::delete('/', 'Api\ResourceController@delete');

      // Attach a file
      Route::post('attach', 'Api\ResourceController@upload');

      // Like/Unlike
      Route::post('like', 'Api\ResourceController@like');

      // Add the resource to a collection
      Route::put('addToCollection', 'Api\ResourceController@addToCollection');

      // Resource tags
      Route::resource('tags', 'Api\ResourceTagController');

    });
});

// Categories
Route::get('categories/{slug}/resources', 'Api\CategoryController@resources');
Route::resource('categories', 'Api\CategoryController');

// Collections
Route::resource('collections', 'Api\CollectionController');

// Tags
Route::resource('tags', 'Api\TagController');

// Polls
Route::post('polls/{id}/vote', 'Api\PollController@vote');
Route::get('polls/{id}/result', 'Api\PollController@result');
Route::get('polls/last', 'Api\PollController@last');

Route::resource('polls', 'Api\PollController');
