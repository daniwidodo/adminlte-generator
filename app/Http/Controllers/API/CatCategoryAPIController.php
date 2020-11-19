<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCatCategoryAPIRequest;
use App\Http\Requests\API\UpdateCatCategoryAPIRequest;
use App\Models\CatCategory;
use App\Repositories\CatCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CatCategoryController
 * @package App\Http\Controllers\API
 */

class CatCategoryAPIController extends AppBaseController
{
    /** @var  CatCategoryRepository */
    private $catCategoryRepository;

    public function __construct(CatCategoryRepository $catCategoryRepo)
    {
        $this->catCategoryRepository = $catCategoryRepo;
    }

    /**
     * Display a listing of the CatCategory.
     * GET|HEAD /catCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $catCategories = $this->catCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($catCategories->toArray(), 'Cat Categories retrieved successfully');
    }

    /**
     * Store a newly created CatCategory in storage.
     * POST /catCategories
     *
     * @param CreateCatCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCatCategoryAPIRequest $request)
    {
        $input = $request->all();

        $catCategory = $this->catCategoryRepository->create($input);

        return $this->sendResponse($catCategory->toArray(), 'Cat Category saved successfully');
    }

    /**
     * Display the specified CatCategory.
     * GET|HEAD /catCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CatCategory $catCategory */
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            return $this->sendError('Cat Category not found');
        }

        return $this->sendResponse($catCategory->toArray(), 'Cat Category retrieved successfully');
    }

    /**
     * Update the specified CatCategory in storage.
     * PUT/PATCH /catCategories/{id}
     *
     * @param int $id
     * @param UpdateCatCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var CatCategory $catCategory */
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            return $this->sendError('Cat Category not found');
        }

        $catCategory = $this->catCategoryRepository->update($input, $id);

        return $this->sendResponse($catCategory->toArray(), 'CatCategory updated successfully');
    }

    /**
     * Remove the specified CatCategory from storage.
     * DELETE /catCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CatCategory $catCategory */
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            return $this->sendError('Cat Category not found');
        }

        $catCategory->delete();

        return $this->sendSuccess('Cat Category deleted successfully');
    }
}
