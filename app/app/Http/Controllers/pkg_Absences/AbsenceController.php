<?php

namespace App\Http\Controllers\pkg_Absences;

use App\Http\Controllers\AppBaseController;
use App\Repositories\pkg_Absences\AbsenceRepository;
use Illuminate\Http\Request;

class AbsenceController extends AppBaseController
{
    protected $absenceRepository;
    public function __construct(AbsenceRepository $absenceRepository)
    {
        $this->absenceRepository = $absenceRepository;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $absences = $this->absenceRepository->searchData($searchQuery);
                return view('pkg_Absences.index', compact('absences'))->render();
            }
        }
        $absences = $this->absenceRepository->paginate();
        return view('pkg_Absences.index', compact('absences'))->render();
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
