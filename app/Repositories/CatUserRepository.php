<?php

namespace App\Repositories;

use App\Models\CatUser;
use App\Repositories\BaseRepository;

/**
 * Class CatUserRepository
 * @package App\Repositories
 * @version November 18, 2020, 5:38 am UTC
*/

class CatUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'avatar'
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
        return CatUser::class;
    }
}
