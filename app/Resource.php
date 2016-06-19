<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'review', 'slug', 'attachment', 'content'];

    protected $hidden = ['pivot'];

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

    /**
     * Get all of the resource's likes.
     */
    public function likesCount()
    {
        return $this->likes()
            ->selectRaw('resource_id, count(*) as total');
    }

    public function collection()
    {
        return $this->belongsToMany('App\Collection')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
