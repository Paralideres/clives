<?php

//Route::get('/home', 'HomeController@index');

/**
 * API
 */

// API route group that we need to protect
Route::group(['prefix' => 'api'], function()
{
    // Authentication route
    Route::post('authenticate', 'AuthenticateController@authenticate');

    // Password reset link request routes...
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::post('password/reset', 'Auth\PasswordController@postReset');

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

        Route::group(['prefix' => '/{user_id}'], function($userId) {

            // Get User Profile
            Route::get('/profile', 'UserController@getProfile');

            // Update user password
            Route::post('/password/reset', 'Auth\PasswordController@postReset');

            // Update User Profile
            Route::put('/profile', 'UserController@updateProfile');

            // Update User Profile Image
            Route::post('/profile/image', 'UserController@updateImage');

            // Delete User Profile Image
            Route::delete('/profile/image', 'UserController@deleteImage');
        });

        Route::resource('/', 'UserController');
    });

    // Resources
    Route::group(['prefix' => 'resources'], function() {

        Route::group(['prefix' => '/{id}'], function() {

          // Attach a file
          Route::post('/attach', 'ResourceController@upload');

          // Like/Unlike
          Route::post('/like', 'ResourceController@like');

          // Add the resource to a collection
          Route::put('/addToCollection', 'ResourceController@addToCollection');

          // Resource tags
          Route::resource('/tags', 'ResourceTagController');

        });

        Route::resource('/', 'ResourceController');
    });

    // Categories
    Route::resource('categories', 'CategoryController');

    // Collections
    Route::resource('collections', 'CollectionController');

    // Tags
    Route::resource('tags', 'TagController');

    // Polls
    Route::resource('polls', 'PollController');

});
