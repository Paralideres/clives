<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($param)
   {
       $resource = Resource::with('tags', 'likesCount', 'user', 'category')
         ->where('id', $param)
         ->orWhere('slug', $param)
         ->firstOrFail();

       $initialState = [
         'resource' => $resource,
         'currentUser' => Auth::user()
       ];

       return response()->view('public.resource', [
         'appName' => 'resource',
         'pageName' => $resource->title,
         'initialState' => $initialState
       ]);
   }
}
