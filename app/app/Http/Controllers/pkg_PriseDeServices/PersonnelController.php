<?php

namespace App\Http\Controllers\pkg_PriseDeServices;

use App\Exceptions\pkg_PriseDeServices\PersonnelAlreadyExistException;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\pkg_Parametres\Avancement;
use App\Models\pkg_Parametres\Etablissement;
use App\Models\pkg_Parametres\Fonction;
use App\Models\pkg_Parametres\Grade;
use App\Models\pkg_Parametres\Specialite;
use App\Models\pkg_Parametres\Ville;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\pkg_PriseDeServices\PersonnelRequest;
use App\Repositories\pkg_PriseDeServices\PersonnelRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PersonnelController extends Controller
{
    protected $personnelRepository;

    public function __construct(PersonnelRepository $personnelRepository)
    {
        $this->personnelRepository = $personnelRepository;
    }
    public function index(Request $request)
    {
        $personnelsData = $this->personnelRepository->paginate();
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $personnelsData = $this->personnelRepository->searchData($searchQuery);
                return view('pkg_PriseDeServices.Personnel.index', compact('personnelsData'))->render();
            }
        }
        return view('pkg_PriseDeServices.Personnel.index', compact('personnelsData'));
    }
    public function create(){
        $dataToEdit = null;
        $villes = Ville::all();
        $etablissements = Etablissement::all();
        $specialites = Specialite::all();
        $fonctions = Fonction::all();
        $avancements = Avancement::all();
        $grades = Grade::all();
        return view("pkg_PriseDeServices.Personnel.create" , compact('dataToEdit' , 'villes' , 'etablissements' , 'specialites' , 'fonctions' , 'avancements' , 'grades' ));
    }
    public function store(PersonnelRequest $request){
        try {
            $validatedData = $request->validated();
            $this->personnelRepository->create($validatedData);
            return redirect()->route('personnels.index')->with('success', 'Le personnels a été ajouté avec succès.');

        } catch (PersonnelAlreadyExistException $e) {
            return back()->withInput()->withErrors(['personnel_exists' => __('pkg_PriseDeServices/User/message.PersonnelAlreadyExistException')]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }
    public function edit(string $id)
    {
        $dataToEdit = $this->personnelRepository->find($id);

        return view('pkg_PriseDeServices.Personnel.edit', compact('dataToEdit'));
    }
}