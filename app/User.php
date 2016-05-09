<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token', 'verified', 'verification_token'
    ];

    public function profile()
    {
        return $this->hasOne('App\UserProfile');
    }
}
