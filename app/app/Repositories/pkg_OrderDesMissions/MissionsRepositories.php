<?php

namespace App\Repositories\Pkg_OrderDesMissions;

use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Models\pkg_Parametres\Etablissement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * Constructeur de la classe MissionRepository.
     */
    public function __construct()
    {
        parent::__construct(new Mission());
    }


    public function getMissions($etablissement): LengthAwarePaginator
    {
        $query = $this->model->with(['moyensTransport', 'users'])->orderBy('data_ordre_mission', 'desc');

        if ($etablissement !== null) {
            $query->whereHas('users.etablissement', function ($query) use ($etablissement) {
                $query->where('nom', $etablissement);
            });
        }

        return $query->paginate($this->paginationLimit);
    }

    /**
     * Crée un nouveau Mission.
     *
     * @param array $data Données du Mission à créer.
     * @return mixed
     * @throws MissionAlreadyExistException Si le Mission existe déjà.
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
     * Recherche les Missions correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filterByTypeMission($etablissement, string $missionType)
    {
        $presentDate = Carbon::now()->toDateString();
        $query = $this->model->with(['moyensTransport', 'users'])->orderBy('data_ordre_mission', 'desc');
        $query->whereHas('users.etablissement', function ($query) use ($etablissement) {
            $query->where('nom', $etablissement);
        });
        if ($missionType == "missions_actuelles") {
            return $query
                ->with(['users', 'moyensTransport'])
                ->where('date_depart', '<=', $presentDate)
                ->where('date_return', '>=', $presentDate)
                ->paginate($this->paginationLimit);
        } elseif ($missionType == "missions_precedentes") {
            return $query
                ->with(['users', 'moyensTransport'])
                ->where('date_return', '<', $presentDate)
                ->paginate($this->paginationLimit);
        } elseif ($missionType == "prochaines_missions") {
            return $query
                ->with(['users', 'moyensTransport'])
                ->where('date_depart', '>', $presentDate)
                ->paginate($this->paginationLimit);
        } else {
            return $query
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
