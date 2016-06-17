<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'review', 'slug', 'attachment', 'content'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get all of the resource's likes.
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function collection()
    {
        return $this->belongsToMany('App\Collection');
    }
}
