<?php

namespace App\Repositories;

use App\Models\CatCategory;
use App\Repositories\BaseRepository;

/**
 * Class CatCategoryRepository
 * @package App\Repositories
 * @version November 19, 2020, 3:11 am UTC
*/

class CatCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return CatCategory::class;
    }
}
