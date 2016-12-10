<?php

namespace App\Http\Controllers\Api;

use App\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagCreateRequest;

class TagController extends Controller
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


     public function index(Request $request)
     {

          if ($request->search) {
            $search = $request->search;
            $resources = Tag::where('label', 'LIKE', "$search%")->orderBy('label', 'ASC')->get();
            return response()->json($resources, 200);

          }
          return response()->json(Tag::simplePaginate(20), 200);
     }

     public function store(TagCreateRequest $request)
     {
          $tag = Tag::firstOrCreate([
              'label' => $request->label,
              'slug' => $this->toSlug($request->label),
          ]);

          return response()->json($tag, 200);
     }

     public function show($id)
     {
          $tag = Tag::with([
            'resources' => function($query) {
              $query->select('id', 'title');
            }])->find($id);

          return response()->json($tag, 200);
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
