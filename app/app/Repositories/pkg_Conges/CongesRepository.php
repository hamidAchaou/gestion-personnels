<?php

namespace App\Repositories;

use App\Models\Conges;
use App\Models\pkg_Conges\Conge;
use Illuminate\Database\Eloquent\Model;

class CongesRepository extends BaseRepository
{
    /**
     * Modèle Eloquent associé au référentiel.
     *
     * @var Conges
     */
    protected $model;

    /**
     * Constructeur de la classe CongesRepository.
     *
     * @param Conges $model
     */
    public function __construct(Conge $model)
    {
        $this->model = $model;
    }

    /**
     * Renvoie les champs recherchables pour le modèle Conges.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return [
            'id',
            'date_debut',
            'date_fin',
            'motif_id',
        ];
    }
}
