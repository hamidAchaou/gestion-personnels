<?php

namespace App\Http\Controllers\pkg_Conges;

use App\Exceptions\pkg_Conges\CongeAlreadyExistException;
use App\Exports\pkg_Conges\CongeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\pkg_Conges\CreateCongeRequest;
use App\Http\Requests\pkg_Conges\UpdateCongeRequest;
use App\Models\pkg_Parametres\Motif;
use App\Repositories\pkg_Conges\CongesRepository;
use App\Repositories\pkg_PriseDeServices\Personnel\PersonnelRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CongesController extends Controller
{
    protected $congesRepository;
    protected $personnels;

    public function __construct(CongesRepository $congesRepository, PersonnelRepository $personnelRepository)
    {
        $this->congesRepository = $congesRepository;
        $this->personnels = $personnelRepository;
    }

    public function index(string $etablissement, Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');

            $conges = $this->congesRepository->searchData($etablissement, $searchValue, $startDate, $endDate);

            return view('pkg_Conges.conges.index', compact('conges', 'etablissement'))->render();
        }

        $conges = $this->congesRepository->paginate($etablissement, 6);
        return view('pkg_Conges.conges.index', compact('conges', 'etablissement'));
    }

    public function decision(string $etablissement, $id)
    {
        $personnel = $this->personnels->find($id);
        $currentDate = Carbon::now()->format('d/m/Y');
        return view('pkg_Conges.conges.decision', compact('personnel', 'currentDate'));
    }

    public function create(string $etablissement, Request $request)
    {
        $firstYear = Carbon::now()->format('Y');
        $lastYear = Carbon::now()->subYear()->format('Y');
        $twoYearsAgo = Carbon::now()->subYears(2)->format('Y');

        $personnels = $this->personnels->PersonnelsOneEtablissement($etablissement);
        $motifs = Motif::all();

        $nombreJoursCongesFirstYear = 0;
        $nombreJoursCongesLastYear = 0;

        if ($request->ajax()) {
            $personnel_id = $request->personnel_id;
            $CongesFirstYear = $this->congesRepository->filterByDate($etablissement, null, null, $firstYear, $personnel_id);
            $CongesLastYear = $this->congesRepository->filterByDate($etablissement, null, null, $lastYear, $personnel_id);

            foreach ($CongesFirstYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesFirstYear += $conge->nombre_jours;
            }

            foreach ($CongesLastYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesLastYear += $conge->nombre_jours;
            }

            $joursRestantsLastYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesLastYear);
            $joursRestantsFirstYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesFirstYear, $joursRestantsLastYear);

            return view('pkg_Conges.conges.details-calcule', compact(
                'etablissement', 'personnels', 'motifs', 'CongesLastYear', 'CongesFirstYear',
                'firstYear', 'lastYear', 'joursRestantsLastYear', 'joursRestantsFirstYear'
            ))->render();
        } else {
            if ($personnels->isNotEmpty()) {
                $personnel_id = $personnels->first()->id;
                $CongesFirstYear = $this->congesRepository->filterByDate($etablissement, null, null, $firstYear, $personnel_id);
                $CongesLastYear = $this->congesRepository->filterByDate($etablissement, null, null, $lastYear, $personnel_id);

                foreach ($CongesFirstYear as $conge) {
                    $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                    $nombreJoursCongesFirstYear += $conge->nombre_jours;
                }

                foreach ($CongesLastYear as $conge) {
                    $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                    $nombreJoursCongesLastYear += $conge->nombre_jours;
                }

                $joursRestantsLastYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesLastYear);
                $joursRestantsFirstYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesFirstYear, $joursRestantsLastYear);
            } else {
                $personnel_id = null;
                $CongesFirstYear = collect();
                $CongesLastYear = collect();
                $joursRestantsLastYear = 0;
                $joursRestantsFirstYear = 0;
            }

            return view('pkg_Conges.conges.create', compact(
                'etablissement', 'personnels', 'motifs', 'CongesFirstYear', 'CongesLastYear',
                'firstYear', 'lastYear', 'joursRestantsLastYear', 'joursRestantsFirstYear'
            ));
        }
    }

    public function store(string $etablissement, CreateCongeRequest $createCongeRequest)
    {
        $validatedData = $createCongeRequest->validated();
        try {
            $this->congesRepository->create($validatedData);
            return redirect()->route('conges.index')->with('success', 'Congés ajouté avec succès');
        } catch (CongeAlreadyExistException $e) {
            return back()->withInput()->withErrors(['conge_exists' => __('Les congés existent déjà')]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['unexpected_error' => __('Une erreur inattendue s\'est produite. Veuillez réessayer plus tard.')]);
        }
    }

    public function show(string $etablissement, Request $request, string $id)
    {
        $personnel_id = $id;
        $firstYear = Carbon::now()->format('Y');
        $lastYear = Carbon::now()->subYear()->format('Y');
        $nombreJoursCongesFirstYear = 0;
        $nombreJoursCongesLastYear = 0;
        $CongesFirstYear = $this->congesRepository->filterByDate($etablissement, null, null, $firstYear, $personnel_id);
        $CongesLastYear = $this->congesRepository->filterByDate($etablissement, null, null, $lastYear, $personnel_id);

        foreach ($CongesFirstYear as $conge) {
            $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
            $nombreJoursCongesFirstYear += $conge->nombre_jours;
        }

        foreach ($CongesLastYear as $conge) {
            $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
            $nombreJoursCongesLastYear += $conge->nombre_jours;
        }

        $joursRestantsLastYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesLastYear);
        $joursRestants = $this->congesRepository->calculateJoursRestants($nombreJoursCongesFirstYear, $joursRestantsLastYear);

        if ($request->has('searchValue')) {
            $searchValue = $request->get('searchValue');
            $personnel = $this->personnels->find($id);
            $conges = $this->congesRepository->getCongesByPersonnelId($searchValue, $personnel_id);

            return view('pkg_Conges.conges.show', compact('personnel', 'conges', 'joursRestants'))->render();
        }

        $personnel = $this->personnels->find($id);
        $conges = $personnel->conges()->paginate(4);

        return view('pkg_Conges.conges.show', compact('personnel', 'conges', 'joursRestants'));
    }

    public function edit(string $etablissement, Request $request, int $id)
    {
        $firstYear = Carbon::now()->format('Y');
        $lastYear = Carbon::now()->subYear()->format('Y');
        $conge = $this->congesRepository->find($id);
        $personnels = $this->personnels->PersonnelsOneEtablissement($etablissement);
        $motifs = Motif::all();

        $nombreJoursCongesFirstYear = 0;
        $nombreJoursCongesLastYear = 0;

        if ($request->ajax()) {
            $personnel_id = $request->personnel_id;
            $CongesFirstYear = $this->congesRepository->filterByDate($etablissement, null, null, $firstYear, $personnel_id);
            $CongesLastYear = $this->congesRepository->filterByDate($etablissement, null, null, $lastYear, $personnel_id);

            foreach ($CongesFirstYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesFirstYear += $conge->nombre_jours;
            }

            foreach ($CongesLastYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesLastYear += $conge->nombre_jours;
            }

            $joursRestantsLastYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesLastYear);
            $joursRestantsFirstYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesFirstYear, $joursRestantsLastYear);

            return view('pkg_Conges.conges.details-calcule', compact(
                'etablissement', 'personnels', 'motifs', 'CongesLastYear', 'CongesFirstYear',
                'firstYear', 'lastYear', 'joursRestantsLastYear', 'joursRestantsFirstYear'
            ))->render();
        } else {
            $personnel_id = $id;
            $CongesFirstYear = $this->congesRepository->filterByDate($etablissement, null, null, $firstYear, $personnel_id);
            $CongesLastYear = $this->congesRepository->filterByDate($etablissement, null, null, $lastYear, $personnel_id);

            foreach ($CongesFirstYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesFirstYear += $conge->nombre_jours;
            }

            foreach ($CongesLastYear as $conge) {
                $conge->nombre_jours = $this->congesRepository->getNombreJoursAttribute($conge->date_debut, $conge->date_fin);
                $nombreJoursCongesLastYear += $conge->nombre_jours;
            }

            $joursRestantsLastYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesLastYear);
            $joursRestantsFirstYear = $this->congesRepository->calculateJoursRestants($nombreJoursCongesFirstYear, $joursRestantsLastYear);

            return view('pkg_Conges.conges.edit', compact(
                'etablissement', 'conge', 'personnels', 'motifs', 'CongesFirstYear', 'CongesLastYear',
                'firstYear', 'lastYear', 'joursRestantsLastYear', 'joursRestantsFirstYear'
            ));
        }
    }

    public function update(string $etablissement, UpdateCongeRequest $updateCongeRequest, string $id)
    {
        $validatedData = $updateCongeRequest->validated();
        $this->congesRepository->update($id, $validatedData);
        return redirect()->route('conges.show', ['conge' => $id])->with('success', 'Congés mis à jour avec succès');
    }

    public function destroy(string $etablissement, Request $request, $id)
    {
        $inpUserId = $request->inpUserId;
        $this->congesRepository->destroy($id);
        return redirect()->route('conges.show', ['conge' => $inpUserId])->with('success', 'Congés supprimé avec succès');
    }

    public function export(string $etablissement, Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $conges = $this->congesRepository->filterByDate($etablissement, $date_debut, $date_fin);
        return Excel::download(new CongeExport($conges), 'conges_export.xlsx');
    }
}
