<?php

namespace App\Http\Controllers;

use Image;
use Storage;

use App\User;
use App\UserProfile;

use Illuminate\Http\Request;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserProfileUpdateRequest;
use App\Http\Requests\User\UserImageProfileImageRequest;
use App\Http\Requests\User\UserDeleteUserRequest;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => [
            'show',
            'store',
            'getProfile'
        ]]);
    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function show($userId)
    {
        $user = User::find($userId);

        if ($user) {
          return response()->json($user);
        }

        return response()->json('Not Found', 404);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create([
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'username' => $request->username
        ]);
        $user_profile = new UserProfile();
        $user->profile()->save($user_profile);
        return response()->json($user);
    }

    public function delete(UserDeleteUserRequest $request, $userId)
    {

        if (User::find($userId)->delete()) {
            return response()->json('', 200);
        }

        return response()->json('Not Found', 404);
    }

    public function getProfile($userId)
    {
        $user = User::find($userId);

        if ($user) {
          return response()->json($user->profile);
        }

        return response()->json('Not Found', 404);
    }

    public function updateProfile(UserProfileUpdateRequest $request, $userId)
    {
        $profile = UserProfile::where('user_id', $userId)->first();
        $profile->fullname = $request->fullname;
        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->birthdate = $request->birthdate;
        $profile->description = $request->description;
        $profile->social_facebook = $request->social_facebook;
        $profile->social_twitter = $request->social_twitter;
        $profile->social_youtube = $request->social_youtube;
        $profile->social_instagram = $request->social_instagram;
        $profile->social_snapchat = $request->social_snapcha;
        $profile->save();
        return response()->json($profile);
    }

    public function updateImage(UserImageProfileImageRequest $request, $userId)
    {
        $profile = User::find($userId)->profile;
        $previous_image = $profile->image;
        $image = $request->file('image');
        list($width, $height) = getimagesize($image);

        // Image Manipulation
        $original_img = Image::make($image)->encode('png');
        $profile_img = Image::make($image)->fit(300)->encode('png');
        $thumb_img = Image::make($image)->fit(100)->encode('png');

        $img_name = str_random(5) . '_' . uniqid($userId);
        $path = storage_path('app/public/assets/uploads/');

        // Image storage
        if ($width > 1000 || $height > 1000) {
          $original_img->widen(1000);
        }

        $original_img->save($path . $img_name . '_original.png');
        $profile_img->save($path . $img_name . '_profile.png');
        $thumb_img->save($path . $img_name . '_thumb.png');

        // Update the DB
        $profile->image = $img_name;
        $profile->save();

        // Delete old File
        if ($previous_image) {
          Storage::delete('public/assets/uploads/'.$previous_image.'_original.png');
          Storage::delete('public/assets/uploads/'.$previous_image.'_profile.png');
          Storage::delete('public/assets/uploads/'.$previous_image.'_thumb.png');
        }

        // @todo Send Image to S3
        return response()->json(['image' => $img_name], 200);
    }

    public function deleteImage(UserDeleteUserRequest $request, $userId)
    {
        $profile = User::find($userId)->profile;
        $previous_image = $profile->image;

        // Update the DB
        $profile->image = null;
        $profile->save();

        // Delete old File
        if ($previous_image) {
          Storage::delete('public/assets/uploads/'.$previous_image.'_original.png');
          Storage::delete('public/assets/uploads/'.$previous_image.'_profile.png');
          Storage::delete('public/assets/uploads/'.$previous_image.'_thumb.png');
        }

        // @todo Send Image to S3
        return response()->json(null, 200);
    }
}
