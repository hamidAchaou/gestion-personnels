<?php

namespace App\Http\Controllers\pkg_PriseDeServices;

use App\Exceptions\pkg_PriseDeServices\CategoryAlreadyExistException;
use App\Http\Controllers\AppBaseController;
use App\Models\pkg_Parametres\Grade;
use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\pkg_PriseDeServices\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\pkg_PriseDeServices\CategoryRequest;

class AvancementController extends AppBaseController
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index(string $etablissement, Request $request)
    {
      
        $categoriesData = $this->categoryRepository->paginate($etablissement );
        // dd($categoriesData);
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $categoriesData = $this->categoryRepository->searchData($etablissement, $searchQuery );
                return view('pkg_PriseDeServices.Category.index', compact('categoriesData'))->render();
            }
        }
        return view('pkg_PriseDeServices.Category.index', compact('categoriesData'));
    }
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $echell = $request->input('echell');

            $data = Grade::where('echell_debut', '<=', $echell)
            ->where('echell_fin', '>=', $echell)
            ->get();
            return response()->json($data);
        }
        $dataToEdit = null;
        $grades = Grade::all();
        $personnels = Personnel::all();
        return view("pkg_PriseDeServices.Category.create", compact('dataToEdit', 'grades', 'personnels'));
    }
    public function store(string $etablissement, CategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->categoryRepository->create($validatedData);
            return redirect()->route('categories.index')->with('success', 'La categorie a été ajouté avec succès.');
        } catch (CategoryAlreadyExistException $e) {
            return back()->withInput()->withErrors(['category_exists' => 'La categorie existe déjà.']);
        } catch (\Exception $e) {
            return abort(500);
        }
    }
    public function show($etablissement, $id){
        $fetchedData1 = $this->categoryRepository->find($id);
        $personnelData =  $fetchedData1['personnelData'];
        $fetchedData =  $fetchedData1['records'];
        // dd($fetchedData);
        return view('pkg_PriseDeServices.Category.show', compact('fetchedData','personnelData'));
    }
    public function destroy($etablissement, int $id){
        $avancement = $this->categoryRepository->destroy($id);
        return redirect()->route('categories.index')->with('success', __('pkg_PriseDeServices/categories.singular') . ' ' . __('app.deleteSucées'));
    
    }
    
}