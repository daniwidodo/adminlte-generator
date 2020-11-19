<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class CatUser
 * @package App\Models
 * @version November 18, 2020, 5:38 am UTC
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 */
class CatUser extends Authenticatable
{
    //use SoftDeletes;

    use Notifiable;

    public $table = 'cat_users';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'avatar' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'password' => 'required',
        'avatar' => 'required',
        'name' => 'required',
        
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    
}
