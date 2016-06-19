<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    // user status enums
    const NOT_VERIFIED = 'NV'; 
    const VERIFIED = 'V';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','verification_token','name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    /**
     * Get all articles of this user
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article','user_id', 'id');
    }

}
