<?php

namespace App\Repositories;

use App\Models\CatImage;
use App\Repositories\BaseRepository;

/**
 * Class CatImageRepository
 * @package App\Repositories
 * @version November 19, 2020, 3:13 am UTC
*/

class CatImageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CatImage::class;
    }
}
