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
        return $this->hasMany('App\Resource')->with('user');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
