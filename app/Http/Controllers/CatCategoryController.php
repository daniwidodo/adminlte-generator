<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCatCategoryRequest;
use App\Http\Requests\UpdateCatCategoryRequest;
use App\Repositories\CatCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CatCategoryController extends AppBaseController
{
    /** @var  CatCategoryRepository */
    private $catCategoryRepository;

    public function __construct(CatCategoryRepository $catCategoryRepo)
    {
        $this->catCategoryRepository = $catCategoryRepo;
    }

    /**
     * Display a listing of the CatCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $catCategories = $this->catCategoryRepository->all();

        return view('cat_categories.index')
            ->with('catCategories', $catCategories);
    }

    /**
     * Show the form for creating a new CatCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('cat_categories.create');
    }

    /**
     * Store a newly created CatCategory in storage.
     *
     * @param CreateCatCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCatCategoryRequest $request)
    {
        $input = $request->all();

        $catCategory = $this->catCategoryRepository->create($input);

        Flash::success('Cat Category saved successfully.');

        return redirect(route('catCategories.index'));
    }

    /**
     * Display the specified CatCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            Flash::error('Cat Category not found');

            return redirect(route('catCategories.index'));
        }

        return view('cat_categories.show')->with('catCategory', $catCategory);
    }

    /**
     * Show the form for editing the specified CatCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            Flash::error('Cat Category not found');

            return redirect(route('catCategories.index'));
        }

        return view('cat_categories.edit')->with('catCategory', $catCategory);
    }

    /**
     * Update the specified CatCategory in storage.
     *
     * @param int $id
     * @param UpdateCatCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCatCategoryRequest $request)
    {
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            Flash::error('Cat Category not found');

            return redirect(route('catCategories.index'));
        }

        $catCategory = $this->catCategoryRepository->update($request->all(), $id);

        Flash::success('Cat Category updated successfully.');

        return redirect(route('catCategories.index'));
    }

    /**
     * Remove the specified CatCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $catCategory = $this->catCategoryRepository->find($id);

        if (empty($catCategory)) {
            Flash::error('Cat Category not found');

            return redirect(route('catCategories.index'));
        }

        $this->catCategoryRepository->delete($id);

        Flash::success('Cat Category deleted successfully.');

        return redirect(route('catCategories.index'));
    }
}
