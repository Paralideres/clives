<?php

namespace App\Http\Controllers\Api;

use App\Resource;
use App\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagCreateRequest;
use App\Http\Requests\Tag\TagDeleteRequest;

class ResourceTagController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:api', ['except' => [
             'index',
             'show'
         ]]);
     }


     public function index($resourceId)
     {
          $resource = Resource::find($resourceId);
          return response()->json($resource->tags()->get(), 200);
     }

     public function show($resourceId, $tagId)
     {
          $resource = Resource::find($resourceId);
          $tag = $resource->tags()->find($tagId);
          return response()->json($tag, 200);
     }

     public function store(TagCreateRequest $request, $resourceId)
     {
          $resource = Resource::find($resourceId);

          if ($resource->tags()->count() >= 3) {
              return response()->json('Not more than 3 tags per resource', 500);
          }

          $tag = Tag::firstOrCreate([
              'label' => $request->label,
              'slug' => $this->toSlug($request->label),
          ]);
          $resource->tags()->attach($tag);

          return response()->json($tag, 200);
     }

     public function destroy(TagDeleteRequest $request, $resourceId, $tagId)
     {
          $resource = Resource::find($resourceId);
          $resource->tags()->detach($tagId);
          return response()->json('', 200);
     }

     /**
      * Snakecase a string
      * @param str $string
      * @return str snakecased string
      */
     private function toSlug($string) {
         return strtolower(preg_replace('/[\s-]/', '_', $string));
     }
}
