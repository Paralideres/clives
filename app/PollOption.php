<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $table = 'poll_options';

    protected $fillable = [ 'option', 'index' ];

    protected $hidden = [ 'poll_id', 'id' ];

    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }
}
