<?php

namespace App\Http\Controllers\pkg_Absences;

use App\Exports\pkg_Absences\JourFerieExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\pkg_Absences\JourFerie;
use App\Http\Controllers\AppBaseController;
use App\Imports\pkg_Absences\JourFerieImport;
use App\Models\pkg_Absences\AnneeJuridique;
use App\Repositories\pkg_Absences\JourFerieRespository;

class JourFerieController extends AppBaseController
{
    protected $jourFerieRespository;
    public function __construct(JourFerieRespository $JourFerieRespository)
    {
        $this->jourFerieRespository = $JourFerieRespository;
    }

    public function index(Request $request)
    {
        $anneeJuridiques = AnneeJuridique::all();
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '' && $searchValue !== 'undefined') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                // $jourFeries = $this->jourFerieRespository->searchData($searchQuery);
                return view('pkg_Absences.index', compact('jourFeries', 'anneeJuridiques'))->render();
            }
        }

        $jourFeries = $this->jourFerieRespository->getJourFerieWithRelations(10);
        return view('pkg_Absences.Jour_ferie.index', compact('jourFeries', 'anneeJuridiques'))->render();
    }

    public function create()
    {
        $anneeJuridiques = AnneeJuridique::all();
        return view('pkg_Absences.Jour_ferie.create', compact('anneeJuridiques'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'annee_juridique_id' => 'required|exists:annee_juridiques,id',
            'nom' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'is_formateur' => 'required',
            'is_administrateur' => 'required',
        ]);

        // Process the data as needed
        $validatedData['is_formateur'] = filter_var($validatedData['is_formateur'], FILTER_VALIDATE_BOOLEAN);
        $validatedData['is_administrateur'] = filter_var($validatedData['is_administrateur'], FILTER_VALIDATE_BOOLEAN);

        // Create the absence using the repository
        $this->jourFerieRespository->create($validatedData);

        // Redirect with success message
        return redirect()
            ->route('jourFerie.index')
            ->with('success', 'Jour férié' . ' ' . __('app.addSucées'));
    }

    public function edit(string $etablissement, JourFerie $jourFerie)
    {
        $anneeJuridiques = AnneeJuridique::all();
        return view('pkg_Absences.Jour_ferie.edit', compact('jourFerie', 'anneeJuridiques'));
    }

    public function update(string $etablissement, Request $request, JourFerie $jourFerie)
    {

        $validatedData = $request->validate([
            'annee_juridique_id' => 'required|exists:annee_juridiques,id',
            'nom' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'is_formateur' => 'required',
            'is_administrateur' => 'required',
        ]);

        // Process the data as needed
        $validatedData['is_formateur'] = filter_var($validatedData['is_formateur'], FILTER_VALIDATE_BOOLEAN);
        $validatedData['is_administrateur'] = filter_var($validatedData['is_administrateur'], FILTER_VALIDATE_BOOLEAN);

        // Create the absence using the repository
        $this->jourFerieRespository->update($jourFerie->id, $validatedData);

        return redirect()
            ->route('jourFerie.index')
            ->with('success', 'Jour férié' . ' ' . __('app.updateSucées'));
    }

    public function destroy(string $etablissement, JourFerie $jourFerie)
    {

        $this->jourFerieRespository->destroy($jourFerie->id);

        return redirect()
            ->route('jourFerie.index')
            ->with('success', 'Jour férié' . ' ' . __('app.deleteSucées'));
    }

    public function export()
    {
        $jourFeries = $this->jourFerieRespository->exportJourFerieWithRelations();

        return Excel::download(new JourFerieExport($jourFeries), 'jour_feries.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new JourFerieImport(), $request->file('file'));

        return redirect()
            ->route('jourFerie.index')
            ->with('success', 'Jour férié' . ' ' . __('app.ImportSucées'));
    }
}
