<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserProfile;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserProfileUpdateRequest;

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
      return response()->json(User::find($userId));
    }

    public function store(UserCreateRequest $request) {
      $user = User::create([
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'username' => $request->username
      ]);
      $user_profile = new UserProfile();
      $user->profile()->save($user_profile);
      return response()->json($user);
    }

    public function getProfile($userId) {
      return response()->json(User::find($userId)->profile);
    }

    public function updateProfile(UserProfileUpdateRequest $request, $user_id) {
      $profile = UserProfile::where('user_id', $user_id)->first();
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
}
