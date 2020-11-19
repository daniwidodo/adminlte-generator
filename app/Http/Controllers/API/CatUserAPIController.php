<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCatUserAPIRequest;
use App\Http\Requests\API\UpdateCatUserAPIRequest;
use App\Models\CatUser;
use App\Repositories\CatUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Hash;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;



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
        // $input = $request->all();

        //////////////

        $input =  $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        if(!empty($input['avatar'])){
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('avatar')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= 'upload_'.$filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('avatar')->storeAs('public', $fileNameToStore);

            $urlPath = URL::to('/').'/'.'storage'.'/'.$fileNameToStore;

            $input['avatar'] = $urlPath;

        } else {
            unset($input['avatar']);
        }

        ///////////////

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

        //////////////

        

        ///////////////

        $catUser = $this->catUserRepository->update($request, $id);

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

    public function updateAvatar(Request $request, $id)
    {
        //
        $this->validate($request, [
            //'title' => 'required',
            //'body' => 'required',
            'image' => 'required|image|max:1999'
        ]);

        $catImage = CatImage::find($id);
        
       // Handle File Upload
       if($request->hasFile('image')){
        // Get filename with the extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('image')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore= $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('image')->storeAs('public', $fileNameToStore);
    }

    if($request->hasFile('image')){
        $catImage->image = $fileNameToStore;
    }



     $catImage->image = $fileNameToStore;
        $catImage->save();

        return $this->sendResponse($catImage->toArray(), 'Cat Image saved successfully');
    }
}
