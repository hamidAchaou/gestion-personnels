<?php

namespace App\Repositories\pkg_PriseDeServices;

use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\pkg_PriseDeServices\PersonnelAlreadyExistException;

class PersonnelRepository extends BaseRepository
{
    /**
     * Les champs de recherche disponibles pour les projets.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'nom',
        'prenom',
        'nom_arab',
        'prenom_arab',
        'cin',
        'date_naissance',
        'telephone',
        'email',
        'password',
        'address',
        'images',
        'matricule',
        'ville_id',
        'fonction_id',
        'ETPAffectation_id',
        'specialite_id',
        'etablissement_id'
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

    public function __construct(Personnel $user)
    {
        $this->model = $user;
    }
    public function create(array $data)
    {
        $email = $data['email'];

        $existingUser = Personnel::where('email', $email)->exists();

        if ($existingUser) {
            throw PersonnelAlreadyExistException::createProject();
        } else {
            return parent::create($data);
        }
    }
     /**
     * Recherche les projets correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchData($etablissement = null, $searchableData = null, $date_debut = null, $date_fin = null, $perPage = 0, $personnel_id = null)
{
    return $this->model->join('etablissements', 'users.etablissement_id', '=', 'etablissements.id')
        ->where('etablissements.nom', '=', $etablissement)
        ->where(function ($query) use ($searchableData) {
            $query->where('users.nom', 'like', '%' . $searchableData . '%')
                ->orWhere('users.prenom', 'like', '%' . $searchableData . '%');
        })
        ->select('users.*') 
        ->paginate($perPage);
}

     /**
     * Recherche les projets correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($etablissement = "", $search = [], $perPage = 0, array $columns = ['*']): LengthAwarePaginator
{
    $query = $this->model->join('etablissements', 'users.etablissement_id', '=', 'etablissements.id')
        ->where('etablissements.nom', '=', $etablissement) 
        ->select('users.*');

    return $query->paginate($perPage);
}
}
