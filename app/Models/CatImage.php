<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CatImage
 * @package App\Models
 * @version November 19, 2020, 3:13 am UTC
 *
 * @property string $image
 */
class CatImage extends Model
{
    use SoftDeletes;

    public $table = 'cat_images';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
