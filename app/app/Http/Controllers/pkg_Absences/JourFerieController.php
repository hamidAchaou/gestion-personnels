<?php

namespace App\Http\Controllers\pkg_Absences;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
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
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '' && $searchValue !== 'undefined') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                // $jourFeries = $this->jourFerieRespository->searchData($searchQuery);
                return view('pkg_Absences.index', compact('jourFeries'))->render();
            }
        }

        $jourFeries = $this->jourFerieRespository->getJourFerieWithRelations();
        return view('pkg_Absences.Jour_ferie.index', compact('jourFeries'))->render();
    }

}
