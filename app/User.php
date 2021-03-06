<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';

    protected $fillable = ['login', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public $timestamps = false;


}
