<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatImageRequest;
use App\Http\Requests\UpdateCatImageRequest;
use App\Repositories\CatImageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CatImageController extends AppBaseController
{
    /** @var  CatImageRepository */
    private $catImageRepository;

    public function __construct(CatImageRepository $catImageRepo)
    {
        $this->catImageRepository = $catImageRepo;
    }

    /**
     * Display a listing of the CatImage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $catImages = $this->catImageRepository->all();

        return view('cat_images.index')
            ->with('catImages', $catImages);
    }

    /**
     * Show the form for creating a new CatImage.
     *
     * @return Response
     */
    public function create()
    {
        return view('cat_images.create');
    }

    /**
     * Store a newly created CatImage in storage.
     *
     * @param CreateCatImageRequest $request
     *
     * @return Response
     */
    public function store(CreateCatImageRequest $request)
    {
        $input = $request->all();

        $catImage = $this->catImageRepository->create($input);

        Flash::success('Cat Image saved successfully.');

        return redirect(route('catImages.index'));
    }

    /**
     * Display the specified CatImage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            Flash::error('Cat Image not found');

            return redirect(route('catImages.index'));
        }

        return view('cat_images.show')->with('catImage', $catImage);
    }

    /**
     * Show the form for editing the specified CatImage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            Flash::error('Cat Image not found');

            return redirect(route('catImages.index'));
        }

        return view('cat_images.edit')->with('catImage', $catImage);
    }

    /**
     * Update the specified CatImage in storage.
     *
     * @param int $id
     * @param UpdateCatImageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatImageRequest $request)
    {
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            Flash::error('Cat Image not found');

            return redirect(route('catImages.index'));
        }

        $catImage = $this->catImageRepository->update($request->all(), $id);

        Flash::success('Cat Image updated successfully.');

        return redirect(route('catImages.index'));
    }

    /**
     * Remove the specified CatImage from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $catImage = $this->catImageRepository->find($id);

        if (empty($catImage)) {
            Flash::error('Cat Image not found');

            return redirect(route('catImages.index'));
        }

        $this->catImageRepository->delete($id);

        Flash::success('Cat Image deleted successfully.');

        return redirect(route('catImages.index'));
    }
}
