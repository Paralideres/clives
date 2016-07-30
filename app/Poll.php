<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{

    protected $table = 'polls';

    protected $hidden = [ 'pivot', 'created_at', 'updated_at', 'deleted_at' ];

    protected $fillable = [ 'question', 'active', 'date_from', 'date_to' ];

    public function options()
    {
        return $this->hasMany('App\PollOption');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function setDateFromAttribute($value)
    {
        $this->attributes['date_from'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDateToAttribute($value)
    {
        $this->attributes['date_to'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
