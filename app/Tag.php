<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $table = 'tags';

    protected $fillable = [ 'label', 'slug' ];

    protected $hidden = [ 'created_at', 'updated_at', 'pivot' ];

    public function resources()
    {
        return $this->belongsToMany('App\Resource')->withTimestamps();
    }
}
