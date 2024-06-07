<?php

namespace App\Http\Controllers\pkg_PriseDeServices;

use App\Http\Controllers\AppBaseController;
use App\Repositories\pkg_PriseDeServices\CategoryRepository;
use Illuminate\Http\Request;

class AvancementController extends AppBaseController
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index(Request $request)
    {
        $categoriesData = $this->categoryRepository->paginate();
        // dd($categoriesData);
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $categoriesData = $this->categoryRepository->searchData($searchQuery);
                return view('pkg_PriseDeServices.Category.index', compact('categoriesData'))->render();
            }
        }
        return view('pkg_PriseDeServices.Category.index', compact('categoriesData'));
    }
}