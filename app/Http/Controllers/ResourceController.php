<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
  * Display a listing of the resource.
  *
  * @return Response
  */
 public function index() {
   return Resource::all()->simplePaginate(15);
 }

 /**
  * Store a newly created resource in storage.
  *
  * @return Response
  */
  public function store() {
    $resource = new Resource(Request::all());
    $resource->user_id = Auth::user()->id;
    $resource->save();
    return $resource;
  }
}
