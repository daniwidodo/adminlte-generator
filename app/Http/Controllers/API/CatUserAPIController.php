<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCatUserAPIRequest;
use App\Http\Requests\API\UpdateCatUserAPIRequest;
use App\Models\CatUser;
use App\Repositories\CatUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CatUserController
 * @package App\Http\Controllers\API
 */

class CatUserAPIController extends AppBaseController
{
    /** @var  CatUserRepository */
    private $catUserRepository;

    public function __construct(CatUserRepository $catUserRepo)
    {
        $this->catUserRepository = $catUserRepo;
    }

    /**
     * Display a listing of the CatUser.
     * GET|HEAD /catUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $catUsers = $this->catUserRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($catUsers->toArray(), 'Cat Users retrieved successfully');
    }

    /**
     * Store a newly created CatUser in storage.
     * POST /catUsers
     *
     * @param CreateCatUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCatUserAPIRequest $request)
    {
        $input = $request->all();

        $catUser = $this->catUserRepository->create($input);

        return $this->sendResponse($catUser->toArray(), 'Cat User saved successfully');
    }

    /**
     * Display the specified CatUser.
     * GET|HEAD /catUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CatUser $catUser */
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            return $this->sendError('Cat User not found');
        }

        return $this->sendResponse($catUser->toArray(), 'Cat User retrieved successfully');
    }

    /**
     * Update the specified CatUser in storage.
     * PUT/PATCH /catUsers/{id}
     *
     * @param int $id
     * @param UpdateCatUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var CatUser $catUser */
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            return $this->sendError('Cat User not found');
        }

        $catUser = $this->catUserRepository->update($input, $id);

        return $this->sendResponse($catUser->toArray(), 'CatUser updated successfully');
    }

    /**
     * Remove the specified CatUser from storage.
     * DELETE /catUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CatUser $catUser */
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            return $this->sendError('Cat User not found');
        }

        $catUser->delete();

        return $this->sendSuccess('Cat User deleted successfully');
    }
}
