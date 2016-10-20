<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = ['label', 'slug', 'description'];

    protected $hidden = [
        'created_at', 'updated_at', 'former_id'
    ];

    public function collections()
    {
        return $this->hasMany('App\Collection');
    }

    public function resources()
    {
        return $this->hasMany('App\Resource')
          ->select('resources.id', 'slug', 'title', 'review', 'user_profiles.fullname as user_fullname', 'user_profiles.user_id')
          ->join('user_profiles', 'user_profiles.user_id', '=', 'resources.user_id')
          ->orderBy('resources.created_at', 'desc');
    }
}
