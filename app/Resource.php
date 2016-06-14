<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'review', 'slug', 'attachment', 'content'];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
