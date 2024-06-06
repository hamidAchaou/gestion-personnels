<?php

namespace App\Http\Controllers\Pkg_OrderDesMissions;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Models\pkg_OrderDesMissions\Transports;
use App\Models\pkg_OrderDesMissions\MoyensTransport;
use App\Models\pkg_OrderDesMissions\MissionPersonnel;
use App\Http\Requests\pkg_OrderDesMissions\MissionRequest;
use App\Repositories\Pkg_OrderDesMissions\MissionsRepositories;


class MissionsController extends Controller
{
    protected $MissionsRepository;
    protected $MoyensTransport;
    protected $Transports;
    protected $Users;
    public function __construct(MissionsRepositories $missionsRepository, MoyensTransport $moyensTransport, Transports $transports, User $user)
    {
        $this->MissionsRepository = $missionsRepository;
        $this->MoyensTransport = $moyensTransport;
        $this->Transports = $transports;
        $this->Users = $user;
    }

    public function index(Request $request)
    {
        // Fetch all missions with their related users and moyensTransport
        $missions = $this->MissionsRepository->paginate();
        // ::with('users', 'moyensTransport')
        return view('pkg_OrderDesMissions.index', compact('missions'));

    }


    public function show(User $mission)
    {
        // Eager load the related data
        // $missions = $this->MissionsRepository->paginate();
        $missions = $mission->missions()->paginate(5);
        return view('pkg_OrderDesMissions.show', compact('mission', 'missions'));
    }


    public function moreDetails(Mission $mission)
    {
        // Eager load the related data
        $mission->load(['users', 'moyensTransport']);
        //
        $transports = Transports::where('mission_id', $mission->id)->get();
        // Now you can access the transports data
        return view('pkg_OrderDesMissions.moreDetails', compact('mission', 'transports'));
    }

    public function certificate(Mission $mission, User $user)
    {
        $presentDate = Carbon::now()->toDateString();
        $transports = Transports::where('mission_id', $mission->id)->where('user', $user->id)->get();
        // dd($transports);
        return view('pkg_OrderDesMissions.attestation', compact('mission', 'user', 'presentDate', 'transports'));
    }



    public function create()
    {
        return view('pkg_OrderDesMissions.create');
    }

    public function edit(string $id)
    {
        return view('pkg_OrderDesMissions.update', compact('id'));
    }

}