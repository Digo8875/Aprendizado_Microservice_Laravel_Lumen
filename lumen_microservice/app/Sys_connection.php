<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sys_connection extends Model
{

    //Nome da tabela
    protected $table = 'sys_connection';

    //TRUE = Cria os campos created_at e updated_at
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sys_key', 'sys_secret', 'sys_access_token',
    ];

    /**
     * The attributes that are not want to be mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        '',
    ];

    /**
     * Get the Users for the Sys_connection.
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_sys_connection');
    }
}
