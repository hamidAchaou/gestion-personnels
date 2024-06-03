<?php

namespace App\Http\Controllers\Pkg_OrderDesMissions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Models\pkg_OrderDesMissions\Transports;
use App\Repositories\Pkg_OrderDesMissions\MissionsRepositories;

class MissionsController extends Controller
{
    // protected $MissionsRepository;
    // protected $CategorieMissions;
    // protected $Competence;
    // public function __construct(MissionsRepositories $MissionsRepository, CategorieMissions $categorieMissions, Competence $competence)
    // {

    //     $this->MissionsRepository = $MissionsRepository;
    //     $this->CategorieMissions = $categorieMissions;
    //     $this->Competence = $competence;
    // }

    public function index(Request $request)
    {
        // Fetch all missions with their related users and moyensTransport
        $missions = Mission::with('users', 'moyensTransport')->paginate(8);
        // dd($missions);
        return view('pkg_OrderDesMissions.index', compact('missions'));

    }


    public function show(Mission $mission)
    {
        return view('pkg_OrderDesMissions.show', compact('mission'));
    }


    public function moreDetails(Mission $mission)
    {
        // Eager load the related data
        $mission->load(['users', 'moyensTransport']);

        $transports = Transports::where('mission_id', $mission->id)->get();
        // Now you can access the transports data
        return view('pkg_OrderDesMissions.moreDetails', compact('mission', 'transports'));
    }

}