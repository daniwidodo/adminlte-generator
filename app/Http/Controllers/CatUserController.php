<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatUserRequest;
use App\Http\Requests\UpdateCatUserRequest;
use App\Repositories\CatUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Hash;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class CatUserController extends AppBaseController
{
    /** @var  CatUserRepository */
    private $catUserRepository;

    public function __construct(CatUserRepository $catUserRepo)
    {
        $this->catUserRepository = $catUserRepo;
    }

    /**
     * Display a listing of the CatUser.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $catUsers = $this->catUserRepository->all();

        return view('cat_users.index')
            ->with('catUsers', $catUsers);
    }

    /**
     * Show the form for creating a new CatUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('cat_users.create');
    }

    /**
     * Store a newly created CatUser in storage.
     *
     * @param CreateCatUserRequest $request
     *
     * @return Response
     */
    public function store(CreateCatUserRequest $request)
    {
        $input = $request->all();

        //////////
        // password handler
        $input['password'] = Hash::make($input['password']);

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

        Flash::success('Cat User saved successfully.');

        return redirect(route('catUsers.index'));
    }

    /**
     * Display the specified CatUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            Flash::error('Cat User not found');

            return redirect(route('catUsers.index'));
        }

        return view('cat_users.show')->with('catUser', $catUser);
    }

    /**
     * Show the form for editing the specified CatUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            Flash::error('Cat User not found');

            return redirect(route('catUsers.index'));
        }

        return view('cat_users.edit')->with('catUser', $catUser);
    }

    /**
     * Update the specified CatUser in storage.
     *
     * @param int $id
     * @param UpdateCatUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatUserRequest $request)
    {
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            Flash::error('Cat User not found');

            return redirect(route('catUsers.index'));
        }

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

        // $catUser = $this->catUserRepository->update($request->all(), $id);
        $catUser = $this->catUserRepository->update($input, $id);

        Flash::success('Cat User updated successfully.');

        return redirect(route('catUsers.index'));
    }

    /**
     * Remove the specified CatUser from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $catUser = $this->catUserRepository->find($id);

        if (empty($catUser)) {
            Flash::error('Cat User not found');

            return redirect(route('catUsers.index'));
        }

        $this->catUserRepository->delete($id);

        Flash::success('Cat User deleted successfully.');

        return redirect(route('catUsers.index'));
    }
}
