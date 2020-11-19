<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCatImageAPIRequest;
use App\Http\Requests\API\UpdateCatImageAPIRequest;
use App\Models\CatImage;
use App\Repositories\CatImageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

/**
 * Class CatImageController
 * @package App\Http\Controllers\API
 */

class CatImageAPIController extends AppBaseController
{
    /** @var  CatImageRepository */
    private $catImageRepository;

    public function __construct(CatImageRepository $catImageRepo)
    {
        $this->catImageRepository = $catImageRepo;
    }

    /**
     * Display a listing of the CatImage.
     * GET|HEAD /catImages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $catImages = $this->catImageRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($catImages->toArray(), 'Cat Images retrieved successfully');
    }

    /**
     * Store a newly created CatImage in storage.
     * POST /catImages
     *
     * @param CreateCatImageAPIRequest $request
     *
     * @return Response
     */
    
    public function store(CreateCatImageAPIRequest $request)
    {
        $input = $request->all();

        if($request->hasFile('image')){
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= 'upload_'.$filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public', $fileNameToStore);

            $urlPath = URL::to('/').'/'.'storage'.'/'.$fileNameToStore;

            $input['image'] = $urlPath;

        // } else {
        //     unset($input['avatar']);
        }

        $catImage = $this->catImageRepository->create($input);

        return $this->sendResponse($catImage->toArray(), 'Cat Image saved successfully');
    }

    /**
     * Display the specified CatImage.
     * GET|HEAD /catImages/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CatImage $catImage */
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            return $this->sendError('Cat Image not found');
        }

        return $this->sendResponse($catImage->toArray(), 'Cat Image retrieved successfully');
    }

    /**
     * Update the specified CatImage in storage.
     * PUT/PATCH /catImages/{id}
     *
     * @param int $id
     * @param UpdateCatImageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatImageAPIRequest $request)
    {
         $input = $request->all();

        //  $catImage->image = $request->input('image'); 
        if($request->hasFile('image')){
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= 'upload_'.$filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public', $fileNameToStore);

            $urlPath = URL::to('/').'/'.'storage'.'/'.$fileNameToStore;

            $input['image'] = $urlPath;

        // } else {
        //     unset($input['avatar']);
        }

        /** @var CatImage $catImage */
        $catImage = $this->catImageRepository->find($id);

        $catImage->image = $request->input('image'); 


        if (empty($catImage)) {
            return $this->sendError('Cat Image not found');
        }

        

        // $catImage = $this->catImageRepository->update($input, $id);
        $catImage = $this->catImageRepository->update($input, $id);

        return $this->sendResponse($catImage->toArray(), 'CatImage updated successfully');
    }

    /**
     * Remove the specified CatImage from storage.
     * DELETE /catImages/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CatImage $catImage */
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            return $this->sendError('Cat Image not found');
        }

        $catImage->delete();

        return $this->sendSuccess('Cat Image deleted successfully');
    }
}
