<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{

    //Nome da tabela
    protected $table = 'frase';

    //TRUE = Cria os campos created_at e updated_at
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'texto',
    ];

    /**
     * The attributes that are not want to be mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'id_user',
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
     * Get the User that owns the Frase.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
