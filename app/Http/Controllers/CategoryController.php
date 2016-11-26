<?php

namespace App\Http\Controllers;

use DB;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\CategoryCreateRequest;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'index',
            'show',
            'resources'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Category::with('collections')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = Category::create([
          'label' => $request->label,
          'slug' => $request->slug,
          'description' => $request->description
        ]);

        return response()->json($category, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {

        $response = Category::with([
          'resources.user' => function($query) {
            $query->simplePaginate(15);
          }
        ])
          ->where('slug', $param)->firstOrFail();

        //$response->resources = $response->resources()->simplePaginate(15);
        return response()->json($response, 200);
    }

    public function resources($param)
    {
        $response = Category::where('slug', $param)
          ->firstOrFail()
          ->resources()
          ->simplePaginate(15);
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryCreateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->label = $request->label;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->save();
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Category::findOrFail($id)->delete(), 200);
    }
}
