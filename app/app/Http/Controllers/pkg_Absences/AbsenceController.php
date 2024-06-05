<?php

namespace App\Http\Controllers\pkg_Absences;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\pkg_Absences\Absence;
use App\Models\pkg_Parametres\Motif;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\pkg_Absences\AbsenceHelper;
use App\Http\Controllers\AppBaseController;
use App\Exports\pkg_Absences\AbsencesExport;
use App\Imports\pkg_Absences\AbsencesImport;
use App\Models\pkg_Parametres\Etablissement;
use App\Repositories\pkg_Absences\AbsenceRepository;

class AbsenceController extends AppBaseController
{
    protected $absenceRepository;
    public function __construct(AbsenceRepository $absenceRepository)
    {
        $this->absenceRepository = $absenceRepository;
    }

    public function index(Request $request)
    {
        $motifs = Motif::all();
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '' && $searchValue !== 'undefined') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $absences = $this->absenceRepository->search($searchQuery);
                return view('pkg_Absences.index', compact('absences', 'motifs'))->render();
            }
        }

        $absences = $this->absenceRepository->getAbsencesWithRelations(2);
        return view('pkg_Absences.index', compact('absences', 'motifs'))->render();
    }

    public function filterByMotif(Request $request)
    {
        $motifNom = $request->input('motif');
        $motifs = Motif::all();

        $absences = $this->absenceRepository->filterByMotif($motifNom);

        return view('pkg_Absences.index', compact('absences', 'motifs'))->render();
    }

    public function filterByDate(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $motifs = Motif::all();

        $absences = $this->absenceRepository->filterByDateRange($date_debut, $date_fin);

        return view('pkg_Absences.index', compact('absences', 'motifs'))->render();
    }

    public function create()
    {
        $motifs = Motif::all();
        $personnels = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', [User::ADMIN, User::RESPONSABLE]);
        })->get();
        return view('pkg_Absences.create', compact('motifs', 'personnels'));
    }

    public function store(Request $request)
    {
        // try {
        // Define the validation rules
        $rules = [
            'date_debut' => 'required|date|before_or_equal:date_fin',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'remarques' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'motif_id' => 'nullable|exists:motifs,id',
        ];

        $data = [
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'remarques' => $request->input('remarques'),
            'user_id' => $request->input('personnel'),
            'motif_id' => $request->input('motif'),
        ];
        // Validate the request data
        $validatedData = Validator::make($data, $rules)->validate();

        // Create the absence using the repository
        $this->absenceRepository->create($validatedData);

        // Redirect with success message
        return redirect()
            ->route('absence.index')
            ->with('success', __('pkg_Absences/absence.singular') . ' ' . __('app.addSucées'));
        // } catch (\Exception $e) {
        //     // Redirect back with an error message
        //     return redirect()->back()->with('error', __('app.errorOccurred'))->withInput();
        // }
    }

    public function show(string $matricule)
    {
        $absencesPersonnel = $this->absenceRepository->getAbsencesPersonnel($matricule, 2);
        $etablissment_id = $absencesPersonnel[0]->personnel->etablissement_id;
        $etablissment = Etablissement::where('id', $etablissment_id)->pluck('nom')->first();
        return view('pkg_Absences.show', compact('absencesPersonnel', 'etablissment'));
    }

    public function edit(Absence $absence)
    {
        $motifs = Motif::all();
        $personnels = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', [User::ADMIN, User::RESPONSABLE]);
        })->get();
        $absence = $this->absenceRepository
            ->allQuery()
            ->where('id', $absence->id)
            ->with('personnel', 'motif')
            ->first();
        return view('pkg_Absences.edit', compact('absence', 'motifs', 'personnels'));
    }

    public function update(Request $request, Absence $absence)
    {
        $rules = [
            'date_debut' => 'required|date|before_or_equal:date_fin',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'remarques' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'motif_id' => 'nullable|exists:motifs,id',
        ];

        $data = [
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'remarques' => $request->input('remarques'),
            'user_id' => $request->input('personnel'),
            'motif_id' => $request->input('motif'),
        ];
        // Validate the request data
        $validatedData = Validator::make($data, $rules)->validate();

        $this->absenceRepository->update($absence->id, $validatedData);

        return redirect()
            ->route('absence.index')
            ->with('success', __('pkg_Absences/absence.singular') . ' ' . __('app.updateSucées'));
    }

    public function destroy(string $id)
    {
        $this->absenceRepository->destroy($id);
        return redirect()
            ->back()
            ->with('success', __('pkg_Absences/absence.singular') . ' ' . __('app.deleteSucées'));
    }

    public function export()
    {
        $absences = $this->absenceRepository->exportAbsenceWithRelations();

        return Excel::download(new AbsencesExport($absences), 'absences.xlsx');

        // return redirect()->route('absence.index')->with('success', __('pkg_Absences/absence.singular') . ' ' . __('app.ExportSucées'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // try {
        Excel::import(new AbsencesImport(), $request->file('file'));
        // } catch (\InvalidArgumentException $e) {
        //     return redirect()->route('project.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        // }
        // catch (\Error $e) {
        //     return redirect()->route('project.index')->withError('Quelque chose s\'est mal passé, vérifiez votre fichier');
        // }
        return redirect()
            ->route('absence.index')
            ->with('success', __('pkg_Absences/absence.plural') . ' ' . __('app.ImportSucées'));
    }

    public function document_absenteisme()
    {
        $motifs = Motif::all();
        return view('pkg_Absences.document-absenteisme', compact('motifs'));
    }


    // public function filterAndPrint(Request $request)
    // {
    //     if ($request->has('date_debut') && $request->has('date_fin') && $request->has('motifs')) {
    //         $date_debut = $request->input('date_debut');
    //         $date_fin = $request->input('date_fin');
    //         $motifs = $request->input('motifs');
    //         $absences = $this->absenceRepository->filterForDocument($date_debut, $date_fin, $motifs);
    //         return view('pkg_Absences.imprimer', compact('absences'));
    //     }
    // }

    public function filterAndPrint(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motifs' => 'required|array',
            'motifs.*' => 'exists:motifs,id', // Validate each motif ID in the array
        ]);

        // Extract validated inputs
        $date_debut = $validatedData['date_debut'];
        $date_fin = $validatedData['date_fin'];
        $motifs = $validatedData['motifs'];

        try {
            // Filter absences based on validated inputs
            $absences = $this->absenceRepository->filterForDocument($date_debut, $date_fin, $motifs);

            // Check if absences are found
            if ($absences->isEmpty()) {
                return redirect()->route('absence.index')->with('error', 'No absences found for the selected criteria.');
            }

            // Return the view to print
            return view('pkg_Absences.imprimer', compact('absences'));
        } catch (\Exception $e) {
            // Log or handle the exception appropriately
            return redirect()->route('absence.index')->with('error', 'An error occurred while processing the request.');
        }
    }




}
