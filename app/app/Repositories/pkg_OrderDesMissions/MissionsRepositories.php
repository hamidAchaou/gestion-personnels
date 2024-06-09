<?php

namespace App\Repositories\Pkg_OrderDesMissions;

use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Models\pkg_Parametres\Etablissement;
use App\Exceptions\Pkg_OrderDesMissions\MissionAlreadyExistException;

class MissionsRepositories extends BaseRepository
{
    protected $paginationLimit = 5;
    protected $fieldsSearchable = [
        'date_depart',
        'date_return',
    ];

    /**
     * Renvoie les champs de recherche disponibles.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldsSearchable;
    }

    /**
     * Constructeur de la classe TechnologieRepository.
     */
    public function __construct()
    {
        parent::__construct(new Mission());
    }

    /**
     * Crée un nouveau Technologie.
     *
     * @param array $data Données du Technologie à créer.
     * @return mixed
     * @throws MissionAlreadyExistException Si le Technologie existe déjà.
     */
    public function create(array $data)
    {
        $numero_mission = $data['numero_mission'];

        $existingMission = $this->model->where('numero_mission', $numero_mission)->exists();

        if ($existingMission) {
            throw MissionAlreadyExistException::createMission();
        } else {
            return parent::create($data);
        }
    }

    /**
     * Recherche les Technologies correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filterByTypeMission(string $missionType)
    {
        $presentDate = Carbon::now()->toDateString();
        /*
        missions_actuelles
        missions_precedentes
        prochaines_missions
        */
        if ($missionType == "missions_actuelles") {
            return $this->model
                ->with(['users', 'moyensTransport'])
                ->where('date_depart', '<=', $presentDate)
                ->where('date_return', '>=', $presentDate)
                ->paginate($this->paginationLimit);
        } elseif ($missionType == "missions_precedentes") {
            return $this->model
                ->with(['users', 'moyensTransport'])
                ->where('date_return', '<', $presentDate)
                ->paginate($this->paginationLimit);
        } else {
            return $this->model
                ->with(['users', 'moyensTransport'])
                ->wherewhere('date_depart', '>', $presentDate)
                ->paginate($this->paginationLimit);
        }
    }


    public function search(string $searchableData)
    {
        $query = $this->model
            ->where('numero_mission', 'like', "%$searchableData%")
            ->orWhere('type_de_mission', 'like', "%$searchableData%")
            ->orWhere('lieu', 'like', "%$searchableData%")
            ->orWhere('numero_ordre_mission', 'like', "%$searchableData%")
            ->orWhereHas('users', function ($q) use ($searchableData) {
                $q->where('nom', 'like', "%$searchableData%")
                    ->orWhere('prenom', 'like', "%$searchableData%")
                    ->orWhere('matricule', 'like', "%$searchableData%");
            })
            ->with(['users', 'moyensTransport']);

        return $query->paginate($this->paginationLimit);
    }



    public function getEtablissementId(string $etablissement)
    {
        return Etablissement::where('nom', $etablissement)->pluck('id')->first();
    }

}