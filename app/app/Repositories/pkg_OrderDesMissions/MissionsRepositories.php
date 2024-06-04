<?php

namespace App\Repositories\Pkg_OrderDesMissions;

use App\Repositories\BaseRepository;
use App\Models\pkg_OrderDesMissions\Mission;
use App\Exceptions\Pkg_OrderDesMissions\MissionAlreadyExistException;

class MissionsRepositories extends BaseRepository
{
    protected $paginationLimit = 5;
    protected $fieldsSearchable = [
        // 'nom',
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
    public function searchData($searchableData, $perPage = 5)
    {
        return $this->model->where(function ($query) use ($searchableData) {
            $query->where('nom', 'like', '%' . $searchableData . '%')
                ->orWhere('description', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }
}