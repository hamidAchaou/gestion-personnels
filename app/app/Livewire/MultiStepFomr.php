<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use GuzzleHttp\Psr7\Request;
use Livewire\WithFileUploads;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Models\pkg_OrderDesMissions\Transports;
use App\Models\pkg_OrderDesMissions\MoyensTransport;
use App\Models\pkg_OrderDesMissions\MissionPersonnel;

class MultiStepFomr extends Component
{
    use WithFileUploads;

    public $numero_mission;
    public $nature;
    public $lieu;
    public $type_de_mission;
    public $numero_ordre_mission;
    public $data_ordre_mission;
    public $date_debut;
    public $date_fin;
    public $date_depart;
    public $heure_de_depart;
    public $date_return;
    public $heure_de_return;
    public $users = [];
    public $moyens_transports = [];
    public $marque = [];
    public $puissance_fiscal = [];
    public $numiro_plaque = [];


    //
    public $totalSteps = 3;
    public $currentStep = 1;

    //
    public $personnels;
    public $moyensTransportsValues;

    //
    public function getUserNameById($id)
    {
        $user = User::find($id);
        return $user ? $user->nom : null;
    }
    public function gettransportUtiliserById($id)
    {
        $user = MoyensTransport::find($id);
        return $user ? $user->nom : null;
    }


    //
    public function mount()
    {
        $this->currentStep = 1;
        $this->personnels = User::all();
        $this->moyensTransportsValues = MoyensTransport::all();
    }

    public function render()
    {
        return view('livewire.multi-step-fomr');
    }

    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->valdateData();

        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
    }
    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function valdateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'numero_mission' => 'required|max:10|unique:missions,numero_mission',
                'users' => 'required|array',
                'nature' => 'nullable|max:40',
                'type_de_mission' => 'required|max:100',
                'numero_ordre_mission' => 'required|max:10|unique:missions,numero_ordre_mission',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'lieu' => 'required|max:100',
                'data_ordre_mission' => 'required|date',
                'date_debut' => 'required|date', // |before:date_fin
                'date_fin' => 'required|date', // |after:date_debut
                'date_depart' => 'required|date',
                'heure_de_depart' => 'required',
                'date_return' => 'required|date',  //|after:date_depart
                'heure_de_return' => 'required',
            ]);
        }
    }

    public function store()
    {
        // $this->resetErrorBag();
        // if ($this->currentStep == 3) {
        //     $this->validate([
        //         'moyens_transports.*' => 'required',
        //         'marque.*' => 'required|max:100',
        //         'puissance_fiscal.*' => 'required|max:100',
        //         'numiro_plaque.*' => 'required|max:100',
        //     ]);
        // }
        $this->resetErrorBag();
        $MissionData = [
            'numero_mission' => $this->numero_mission,
            'nature' => $this->nature,
            'lieu' => $this->lieu,
            'type_de_mission' => $this->type_de_mission,
            'numero_ordre_mission' => $this->numero_ordre_mission,
            'data_ordre_mission' => $this->data_ordre_mission,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'date_depart' => $this->date_depart,
            'heure_de_depart' => $this->heure_de_depart,
            'heure_de_return' => $this->heure_de_return,
            'date_return' => $this->date_return,
        ];

        $mission = Mission::create($MissionData);

        foreach ($this->users as $userId) {
            MissionPersonnel::create([
                'user_id' => $userId,
                'mission_id' => $mission->id,
            ]);
        }

        foreach ($this->users as $user) {
            Transports::create([
                'transport_utiliser' => $this->gettransportUtiliserById($this->moyens_transports[$user] ?? ''),
                'marque' => $this->marque[$user] ?? '',
                'puissance_fiscal' => $this->puissance_fiscal[$user] ?? '',
                'numiro_plaque' => $this->numiro_plaque[$user] ?? '',
                'user' => $user,
                'moyens_transports_id' => isset($this->moyens_transports[$user]) ? (int) $this->moyens_transports[$user] : null, // Ensure it is an integer or null
                'mission_id' => $mission->id,
            ]);
        }

        session()->flash('message', 'Mission created successfully.');
        return redirect()->route('missions.index');
        // dd($MissionData);
    }

}