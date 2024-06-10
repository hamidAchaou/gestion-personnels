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
use App\Models\User;
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
    public function index(string $etablissement, Request $request)
    {
        $personnelsData = $this->personnelRepository->paginate($etablissement , 4);
        $user = User::where('nom' , 'admin')->first();
        $userId = $user->id;
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $personnelsData = $this->personnelRepository->searchData($etablissement, $searchQuery);
                return view('pkg_PriseDeServices.Personnel.index', compact('personnelsData','userId'))->render();
            }
        }
        return view('pkg_PriseDeServices.Personnel.index', compact('personnelsData','userId'));
    }
    public function create($etablissement)
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
    public function store(string $etablissement, PersonnelRequest $request)
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

    public function edit(string $etablissement, string $id)
    {
        $dataToEdit = $this->personnelRepository->find($id);
        $villes = Ville::all();
        $etablissements = Etablissement::all();
        $specialites = Specialite::all();
        $fonctions = Fonction::all();
        $avancements = Avancement::all();

        return view('pkg_PriseDeServices.Personnel.edit', compact('dataToEdit', 'villes', 'etablissements', 'specialites', 'fonctions', 'avancements'));
    }
    public function update(string $etablissement, int $id, Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'nom_arab' => 'required|string|max:255',
            'prenom_arab' => 'required|string|max:255',
            'cin' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . '|max:255',
            'address' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ville_id' => 'required|numeric|max:255',
            'etablissement_id' => 'required|numeric|max:255',
            'ETPAffectation_id' => 'required|numeric',
            'specialite_id' => 'required|numeric|max:255',
            'fonction_id' => 'required|numeric|max:255',
            'matricule' => 'required|numeric'
        ]);

        // Handle image upload if present
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['images'] = $imageName;
        }

        $personnelsData = $this->personnelRepository->update($id, $data);

        return redirect()->route('personnels.index')->with('success', 'Le personnel a été modifié avec succès.');
    }
    public function show(string $etablissement, int $id)
    {
        $fetchedData = $this->personnelRepository->find($id);
        return view('pkg_PriseDeServices.Personnel.show', compact('fetchedData'));
    }
    public function export($etablissement )
    {
        $personnels = $this->personnelRepository->all();

        return Excel::download(new PersonnelExport($personnels), 'personnels_export.xlsx');
    }
    public function import($etablissement ,Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new PersonnelImport, $request->file('file'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('personnels.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('personnels.index')->with('success', __('pkg_PriseDeServices/personnels.singular') . ' ' . __('app.addSucées'));
    }
    public function destroy(string $etablissement, int $id)
    {
        $personnel = $this->personnelRepository->destroy($id);
        return redirect()->route('personnels.index')->with('success', __('pkg_PriseDeServices/personnels.singular') . ' ' . __('app.deleteSucées'));
    }
    public function attestation($etablissement,$id)
    {
        $personnelsData = $this->personnelRepository->find($id);
        $avancement = Avancement::where('personnel_id', $id)->latest()->first();
        $grade = null;
        if ($avancement) {
            $gradeData = Grade::where('echell_debut', '<=', $avancement->echell)
                ->where('echell_fin', '>=', $avancement->echell)
                ->first();
                $grade = $gradeData->nom;

        } else {
            $gradeData = null;
        }
        return view('pkg_PriseDeServices.Personnel.attestation', compact('personnelsData', 'grade'));
    }
}