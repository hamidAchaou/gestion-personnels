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
use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Http\Request;
use App\Http\Requests\pkg_PriseDeServices\PersonnelRequest;
use App\Repositories\pkg_PriseDeServices\PersonnelRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\pkg_PriseDeServices\PersonnelExport;
use App\Imports\pkg_PriseDeServices\PersonnelImport;
use Illuminate\Support\Str;

class PersonnelController extends AppBaseController
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
    public function create()
    {
        $dataToEdit = null;
        $villes = Ville::all();
        $etablissements = Etablissement::all();
        $specialites = Specialite::all();
        $fonctions = Fonction::all();
        $avancements = Avancement::all();
        $grades = Grade::all();
        return view("pkg_PriseDeServices.Personnel.create", compact('dataToEdit', 'villes', 'etablissements', 'specialites', 'fonctions', 'avancements', 'grades'));
    }
    public function store(PersonnelRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('images')) {
                $slug = Str::slug($request->nom, '-');
                $newImageName = uniqid() . '-' . $slug . '.' . $request->file('images')->extension();
                $request->images->move(public_path('images'), $newImageName);
                $validatedData['images'] = $newImageName;
            }

            $this->personnelRepository->create($validatedData);

            return redirect()->route('personnels.index')->with('success', 'Le personnel a été ajouté avec succès.');
        } catch (PersonnelAlreadyExistException $e) {
            return back()->withInput()->withErrors(['personnel_exists' => __('pkg_PriseDeServices/User/message.PersonnelAlreadyExistException')]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function edit(string $id)
    {
        $dataToEdit = $this->personnelRepository->find($id);
        $villes = Ville::all();
        $etablissements = Etablissement::all();
        $specialites = Specialite::all();
        $fonctions = Fonction::all();
        $avancements = Avancement::all();

        return view('pkg_PriseDeServices.Personnel.edit', compact('dataToEdit', 'villes', 'etablissements', 'specialites', 'fonctions', 'avancements'));
    }
    public function show(int $id)
    {
        $fetchedData = $this->personnelRepository->find($id);
        return view('pkg_PriseDeServices.Personnel.show', compact('fetchedData'));
    }
    public function export()
    {
        $personnels = $this->personnelRepository->all();

        return Excel::download(new PersonnelExport($personnels), 'personnels_export.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new PersonnelImport, $request->file('file'));
        } 
        catch (\InvalidArgumentException $e) {
            return redirect()->route('personnels.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('personnels.index')->with('success',__('pkg_PriseDeServices/personnels.singular').' '.__('app.addSucées'));
    }
    public function destroy(int $id)
    {
        $personnel = $this->personnelRepository->destroy($id);
        return redirect()->route('personnels.index')->with('success', __('pkg_PriseDeServices/personnels.singular') . ' ' . __('app.deleteSucées'));
    }
    public function attestation($id){
        $personnelsData = $this->personnelRepository->find($id);
        return view('pkg_PriseDeServices.Personnel.attestation', compact('personnelsData'));
    }
}