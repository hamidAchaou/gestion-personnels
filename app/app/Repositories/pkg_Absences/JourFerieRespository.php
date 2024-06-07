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

    public function exportJourFerieWithRelations(){
        return $this->model->with('anneeJuridique')->get();
    }

    public function filterByAnneeJuridique($perPage){
        // return $this->model->with('anneeJuridique')->paginate($perPage);
    }

}
