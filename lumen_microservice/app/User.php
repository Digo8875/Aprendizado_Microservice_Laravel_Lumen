<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'id_sys_connection',
    ];

    /**
     * Get the frases for the User.
     */
    public function frases()
    {
        return $this->hasMany('App\Frase', 'id_user');
    }

    /**
     * Get the Sys_connection that owns the User.
     */
    public function sys_connection()
    {
        return $this->belongsTo('App\Sys_connection', 'id_sys_connection');
    }
}
