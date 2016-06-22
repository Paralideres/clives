<?php

namespace App\Http\Controllers;

use App\Poll;
use App\PollOption;
use Illuminate\Http\Request;
use App\Http\Requests\Poll\PollCreateRequest;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
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

    public function index()
    {
        return response()->json(Poll::simplePaginate(10));
    }

    public function show($id)
    {
        return response()->json(Poll::with('options')->findOrFail($id), 200);
    }

    public function store(PollCreateRequest $request)
    {
        $poll = Poll::create([
          'question' => $request->question,
          'date_from' => $request->from,
          'date_to' => $request->to,
          'active' => $request->active
        ]);

        $options = array_map(function($option, $key) {
            return new PollOption([
                'option' => $option,
                'index' => $key
            ]);
        }, $request->options, array_keys($request->options));

        $poll->options()->saveMany($options);

        $poll->load('options');

        return response()->json($poll, 200);
    }

}
