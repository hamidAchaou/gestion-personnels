<?php

namespace App\Http\Controllers\GestionConges;

use App\Exceptions\GestionConges\CongeAlreadyExistException;
use App\Exports\GestionConges\CongeExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCongeRequest;
use App\Http\Requests\GestionConges\UpdateCongeRequest;
use App\Models\GestionParametre\Motif;
use App\Models\GestionPersonnels\Personnel;
use App\Repositories\GestionConges\CongesRepository;
use App\Repositories\GestionPersonnels\PersonnelRepository;
use App\Repositories\pkg_Conges\CongesRepository as Pkg_CongesCongesRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CongesController extends Controller
{
    protected $congesRepository;
    protected $personnels;

    public function __construct(Pkg_CongesCongesRepository $congesRepository, PersonnelRepository $personnelRepository)
    {
        $this->congesRepository = $congesRepository;
        $this->personnels = $personnelRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');

            if ($searchValue !== '' || ($startDate && $endDate)) {
                $searchQuery = $searchValue !== '' ? str_replace(' ', '%', $searchValue) : null;
                $conges = $this->congesRepository->filterByDate($startDate, $endDate, $searchQuery);
                return view('GestionConges.conges.index', compact('conges'))->render();
            }
        }

        $conges = $this->congesRepository->paginate();
        return view('GestionConges.conges.index', compact('conges'));
    }

    public function decision($id)
    {
        $personnel = $this->personnels->find($id);
        $currentDate = now()->format('d/m/Y');
        return view('GestionConges.conges.decision', compact('personnel', 'currentDate'));
    }

    public function create()
    {
        $personnels = $this->personnels->paginate()->all();
        $motifs = Motif::all();
        return view('GestionConges.conges.create', compact('personnels', 'motifs'));
    }

    public function store(CreateCongeRequest $createCongeRequest)
    {
        $validatedData = $createCongeRequest->validated();
        try {
            $conge = $this->congesRepository->create($validatedData);
            return to_route('conges.index')->with('success', 'Congés ajouté avec succès');
        } catch (CongeAlreadyExistException $e) {
            return back()->withInput()->withErrors(['conge_exists' => __('GestionConges/Conges/message.existCongeException')]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['unexpected_error' => __('GestionConges/Conges/message.unexpectedError')]);
        }
    }

    public function show(string $id)
    {
        $personnel = $this->personnels->find($id);
        $conges = $personnel->conges()->paginate(4);
        return view('GestionConges.conges.show', compact('personnel', 'conges'));
    }

    public function edit(string $id)
    {
        $conge = $this->congesRepository->find($id);
        $personnels = Personnel::all();
        $motifs = Motif::all();
        return view('GestionConges.conges.edit', compact('conge', 'personnels', 'motifs'));
    }

    public function update(UpdateCongeRequest $updateCongeRequest, string $id)
    {
        $validatedData = $updateCongeRequest->validated();
        $conge = $this->congesRepository->update($id, $validatedData);
        return to_route('conges.show', ['conge' => $id])->with('success', 'Congés mis à jour avec succès');
    }

    public function destroy(Request $request, $id)
    {
        $inpUserId = $request->inpUserId;
        $this->congesRepository->destroy($id);
        return to_route('conges.show', ['conge' => $inpUserId])->with('success', 'Congés supprimé avec succès');
    }

    public function export(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $conges = $this->congesRepository->filterByDate($date_debut, $date_fin);
        return Excel::download(new CongeExport($conges), 'conges_export.xlsx');
    }
}
