<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{

    protected $table = 'polls';

    protected $hidden = [ 'pivot' ];

    protected $fillable = [ 'question', 'active', 'date_from', 'date_to' ];

    public function options()
    {
        return $this->hasMany('App\PollOption');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
