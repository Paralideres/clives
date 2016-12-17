<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements AuthorizableContract,
                                    CanResetPasswordContract
{
    use HasApiTokens, CanResetPassword, EntrustUserTrait, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token', 'verified', 'verification_token', 'deleted_at',
        'former_id', 'former_pwd', 'email', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user profile.
     */
    public function profile()
    {
        return $this->hasOne('App\UserProfile');
    }

    /**
     * Get all of the user's resources.
     */
    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    /**
     * Get all of the user's likes.
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     *  Get all the user collections
     */
    public function collections()
    {
        return $this->hasMany('App\Collection');
    }

    /**
     *  Get all the user polls
     */
    public function polls()
    {
        return $this->belongsToMany('App\Poll');
    }

    /**
     *  Get all the user votes
     */
    public function pollVote()
    {
        return $this->hasMany('App\PollVote');
    }

    public function getJWTIdentifier()
    {
        // Eloquen model method
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
