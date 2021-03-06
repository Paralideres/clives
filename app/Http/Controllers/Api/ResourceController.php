<?php

namespace App\Http\Controllers\Api;

use App\Resource;
use App\Like;
use App\Collection;
use App\Tag;
use Storage;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Resource\ResourceCreateRequest;
use App\Http\Requests\Resource\ResourceDeleteRequest;
use App\Http\Requests\Resource\ResourceUploadRequest;
use App\Http\Requests\Resource\ResourceUpdateRequest;
use App\Http\Requests\Resource\ResourceAddToCollectionRequest;
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
       $this->middleware('auth:api', ['except' => [
           'index',
           'show',
           'file'
       ]]);
   }

  /**
  * Display a listing of the resource.
  *
  * @return Response
  */
 public function index(Request $request)
 {
    // Create Request to Handle this limit Type
    $limit = intval($request->limit);
    $limit = $limit > 0 && $limit < 20 ? $limit : 20;

    $resources = Resource::with('likesCount', 'category', 'user')
      ->orderBy('created_at', 'desc')
      ->simplePaginate($limit);
    return response()->json($resources);
 }

 /**
  * Store a newly created resource in storage.
  *
  * @return Response
  */
  public function store(ResourceCreateRequest $request) {

      $resource = new Resource([
        'title' => $request->title,
        'slug' => $this->toSlug($request->title).'_'.uniqid(),
        'review' => $request->review,
        'category_id' => $request->category_id
      ]);

      Auth::user()->resources()->save($resource);
      return response()->json($resource);
  }

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
      return response()->json($resource);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(ResourceDeleteRequest $request, $id)
  {
      $resource = Resource::find($id);

      if ($resource) {
        return response()->json($resource->delete(), 200);
      } else {
        return response()->json('Error', 500);
      }
  }

  public function update(ResourceUpdateRequest $request, $id)
  {
      $resource = Resource::find($id);
      $resource->title = $request->title;
      $resource->review = $request->review;
      $resource->content = $request->content;
      $resource->category_id = $request->category_id;
      $resource->save();
      return response()->json($resource, 200);
  }

  public function upload(ResourceUploadRequest $request, $id) {
      $resource = Resource::find($id);
      $previous_attachment = $resource->attachment;

      $file = $request->file('resource');

      $extension = $file->guessExtension();
      $filename = $resource->slug . '_'.uniqid($id) . '.' . $extension;

      $path = storage_path('resources_files/');

      $file->move($path, $filename);

    if ($file) {
        $resource->attachment = $filename;
        $resource->save();

        if ($previous_attachment) {
            Storage::delete('resources_files/' . $previous_attachment);
        }

        return response()->json(['attachment' => $resource->attachment], 200);
    } else {
        return response()->json($file, 500);
    }
  }

  public function file($id, $docId) {
      $resource = Resource::where([
        'id' => $id,
        'attachment' => $docId
      ])->firstOrFail();
      $filePath = storage_path('resources_files/' . $resource->attachment);
      return response()->download($filePath);
  }

  public function like($id) {
      $resource = Resource::find($id);
      $like = $resource->likes()->where('user_id', Auth::id())->first();

      if ($like) {
          $like->delete();

          return response()->json(null, 200);

      } else {
          $new_like = new Like([ 'user_id' => Auth::id() ]);
          $resource->likes()->save($new_like);

          return response()->json(null, 200);
      }
  }

  public function addToCollection(ResourceAddToCollectionRequest $request, $id) {
      $resource = Resource::find($id);
      $collection = Collection::find($request->collection_id);

      $collection->resources()->save($resource);
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
