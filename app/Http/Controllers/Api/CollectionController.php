<?php

namespace App\Http\Controllers\Api;

use App\Collection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Collection\CollectionCreateRequest;


class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'index',
            'show',
        ]]);
    }

    /**
     * Display a listing of the collections.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Collection::all(), 200);
    }

    /**
     * Store a new collection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionCreateRequest $request)
    {
        $collection = new Collection([
          'label' => $request->label,
          'slug' => $this->toSlug($request->label).'_'.uniqid(),
          'description' => $request->description,
          'category_id' => $request->category
        ]);

        Auth::user()->collections()->save($collection);
        return response()->json($collection, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Collection::with('resources')->findOrFail($id), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionCreateRequest $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->label = $request->label;
        $collection->slug = $this->toSlug($request->label);
        $collection->description = $request->description;
        $collection->category_id = $request->category;
        $collection->save();
        return response()->json($collection, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Collection::findOrFail($id)->delete(), 200);
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
