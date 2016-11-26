<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'review', 'slug', 'attachment', 'content'];

    protected $hidden = ['pivot', 'category_id', 'deleted_at'];

    public function getTitleAttribute($value)
    {
        return html_entity_decode(strip_tags($value));
    }

    public function getReviewAttribute($value)
    {
        return html_entity_decode(strip_tags($value));
    }

    public function getContentAttribute($value)
    {
        return html_entity_decode(strip_tags($value));
    }

    public function user()
    {
        return $this->belongsTo('App\User')
          ->select('users.id', 'users.username', 'user_profiles.fullname')
          ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
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
            ->selectRaw('resource_id, count(*) as total')->groupBy('resource_id');
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
