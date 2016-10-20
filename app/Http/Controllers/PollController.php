<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Poll;
use App\PollOption;
use App\PollVote;
use Illuminate\Http\Request;
use App\Http\Requests\Poll\PollCreateRequest;
use App\Http\Requests\Poll\PollVoteRequest;
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
           'show',
           'last'
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

    public function last()
    {
        $monthStart = new Carbon('first day of this month');
        $monthEnd = new Carbon('last day of this month');

        return response()->json(
          Poll::with('options')
            ->orderBy('created_at', 'asc')
            ->where('active', '=', '1')
            ->whereDate('date_from', '>=', $monthStart->toDateString())
            ->whereDate('date_to', '<=', $monthEnd->toDateString())
            ->first()
          );
    }

    public function store(PollCreateRequest $request)
    {
        $poll = Poll::create([
          'question' => $request->question,
          'date_from' => $request->date_from,
          'date_to' => $request->date_to,
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

    public function update(PollCreateRequest $request, $id)
    {
        $poll = Poll::find($id);

        $poll->question = $request->question;
        $poll->date_from = $request->date_from;
        $poll->date_to = $request->date_to;
        $poll->active = $request->active;

        $poll->options()->delete();

        $options = array_map(function($option, $key) {
            return new PollOption([
                'option' => $option,
                'index' => $key
            ]);
        }, $request->options, array_keys($request->options));

        $poll->options()->saveMany($options);
        $poll->save();
        $poll->load('options');

        return response()->json($poll, 200);
    }

    public function vote(PollVoteRequest $request, $id) {

        $hasVoted = Auth::user()->pollVote()->where([
            'poll_id' => $id,
            'poll_options_id' => $request->option
        ])->first();

        if ($hasVoted) {
            return response()->json('Only one vote per user per poll', 400);
        }

        $pollVote = new PollVote([
            'poll_id' => $id,
            'poll_options_id' => $request->option
        ]);

        Auth::user()->pollVote()->save($pollVote);
        return response()->json(200);
    }

    public function result($id) {
        $poll = Poll::with('options.votes')->findOrFail($id);
        return response()->json($poll, 200);
    }

}
