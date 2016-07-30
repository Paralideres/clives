<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * Get all the team Users
     */
    public function users() {
        return this->hasMany('App\User');
    }

    public function resources() {
        return this->hasMany('App\Team_Resource');
    }
}
