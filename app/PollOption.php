<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $table = 'poll_options';

    protected $fillable = [ 'option', 'index' ];

    protected $hidden = [ 'poll_id' ];

    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    public function votes()
    {
        return $this->hasOne('App\PollVote', 'poll_options_id', 'id')
            ->selectRaw('poll_options_id, count(*) as total');
    }
}
