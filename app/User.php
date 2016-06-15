<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    JWTableContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token', 'verified', 'verification_token', 'deleted_at'
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
