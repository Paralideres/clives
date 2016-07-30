<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected $table = 'poll_user';

    protected $fillable = [ 'poll_id', 'user_id', 'poll_options_id' ];

    protected $hidden = [ 'poll_options_id' ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function options()
    {
        return $this->belongsTo('App\PollOption');
    }
}
