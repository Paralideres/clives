<?php

Route::get('/', function() {
  if (Auth::check()) {
      return File::get(public_path() . '/static/teams/index.html');
  } else {
    return File::get(public_path() . '/static/front-page/index.html');
  }
});

Route::get('/login', function() {
  return File::get(public_path() . '/static/front-page/index.html');
})->middleware('guest');


Route::get('/resources', function() {
  return File::get(public_path() . '/static/teams/index.html');
})->middleware('auth');

/**
 * API
 */

// API route group that we need to protect
Route::group(['prefix' => 'api'], function()
{
    //User Actions
    Route::group(['prefix' => 'account'], function() {

      // Get logged user
      Route::get('/', 'UserController@currentUser');

      // Authentication route
      Route::post('login', 'AuthenticateController@authenticate');

      // Clear cookie route
      Route::post('logout', 'AuthenticateController@clearCookie');

      // Password reset link request routes...
      Route::post('password/email', 'Auth\PasswordController@postEmail');

      // Password reset routes...
      Route::post('password/reset', 'Auth\PasswordController@postReset');
    });


    // Route to create a new role
    Route::post('role', 'RolesController@createRole');

    // Route to create a new permission
    Route::post('permission', 'RolesController@createPermission');

    // Route to assign role to user
    Route::post('assign-role', 'RolesController@assignRole');

    // Route to attache permission to a role
    Route::post('attach-permission', 'RolesController@attachPermission');


    //User Actions
    Route::group(['prefix' => 'users'], function() {

        // List Users
        Route::get('/', 'UserController@index');

        // Create User
        Route::post('/', 'UserController@create');

        // User Methods
        Route::group(['prefix' => '{id}'], function() {

            // Show User
            Route::get('/', 'UserController@show');

            // Update User
            Route::put('/', 'UserController@update');

            // Delete User
            Route::delete('/', 'UserController@delete');

            // Get User Profile
            Route::get('profile', 'UserController@getProfile');

            // Update user password
            Route::post('password/reset', 'Auth\PasswordController@postReset');

            // Update User Profile
            Route::put('profile', 'UserController@updateProfile');

            // Update User Profile Image
            Route::post('profile/image', 'UserController@updateImage');

            // Delete User Profile Image
            Route::delete('profile/image', 'UserController@deleteImage');
        });
    });

    // Resources
    Route::group(['prefix' => 'resources'], function() {

        // List Resource
        Route::get('/', 'ResourceController@index');

        // Create Resource
        Route::post('/', 'ResourceController@create');

        Route::group(['prefix' => '{id}'], function() {

          // Show Resource
          Route::get('/', 'ResourceController@show');

          // Update Resource
          Route::put('/', 'ResourceController@update');

          // Delete Resource
          Route::delete('/', 'ResourceController@delete');

          // Attach a file
          Route::post('attach', 'ResourceController@upload');

          // Like/Unlike
          Route::post('like', 'ResourceController@like');

          // Add the resource to a collection
          Route::put('addToCollection', 'ResourceController@addToCollection');

          // Resource tags
          Route::resource('tags', 'ResourceTagController');

        });
    });

    // Categories
    Route::resource('categories', 'CategoryController');

    // Collections
    Route::resource('collections', 'CollectionController');

    // Tags
    Route::resource('tags', 'TagController');

    // Polls
    Route::post('polls/{id}/vote', 'PollController@vote');
    Route::get('polls/{id}/result', 'PollController@result');

    Route::resource('polls', 'PollController');

});
