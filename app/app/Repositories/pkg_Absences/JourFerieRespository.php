<?php

namespace App\Repositories\pkg_Absences;

use App\Repositories\BaseRepository;
use App\Models\pkg_Absences\JourFerie;
use App\Exceptions\pkg_Absences\JourFerieAlreadyExistException;

/**
 * Classe ProjetRepository qui gère la persistance des projets dans la base de données.
 */
class JourFerieRespository extends BaseRepository
{
    /**
     * Les champs de recherche disponibles pour les projets.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'nom'
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
     * Constructeur de la classe ProjetRepository.
     */
    public function __construct()
    {
        parent::__construct(new JourFerie());
    }

    public function create(array $data)
    {
        $annee_juridique_id = $data['annee_juridique_id'];
        $date_debut = $data['date_debut'];
        $date_fin = $data['date_fin'];

        $existingJourFerie = $this->model
            ->where('annee_juridique_id', $annee_juridique_id)
            ->where('date_debut', $date_debut)
            ->where('date_fin', $date_fin)
            ->exists();

        if ($existingJourFerie) {
            throw JourFerieAlreadyExistException::create();
        }
        return parent::create($data);
    }

    public function getJourFerieWithRelations($perPage = 2)
    {
        return $this->model->with('anneeJuridique')->paginate($perPage);
    }

    public function exportJourFerieWithRelations()
    {
        return $this->model->with('anneeJuridique')->get();
    }

    public function filterByAnneeJuridique($perPage)
    {
        // return $this->model->with('anneeJuridique')->paginate($perPage);
    }

    /**
     * Recherche les projets correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(string $searchableData, int $perPage = 4)
    {
        // Get the etablissement_id based on the provided etablissement name

        // Subquery to get the IDs of the last absences for each personnel

        // Main query to fetch the absences with relations using the subquery and applying search
        $query = $this->model
            ->where('nom', $searchableData)
            ->with('anneeJuridique');

        return $query->paginate($perPage);
    }

}
