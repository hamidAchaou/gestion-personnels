<?php

namespace App\Repositories\pkg_PriseDeServices\Personnel;

use App\Models\pkg_Parametres\Avancement;
use App\Models\pkg_Parametres\Grade;
use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\BaseRepository;

class PersonnelRepository extends BaseRepository
{
    protected $model;

    public function __construct(Personnel $personnel)
    {
        $this->model = $personnel;
    }

    /**
     * Retourne les champs qui peuvent être utilisés pour la recherche.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return [
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
            'grade_id',
            'specialite_id',
            'etablissement_id',
            'avancement_id',
        ];
    }

    public function PersonnelsOneEtablissement($etablissement = null, array $search = [], int $skip = null, int $limit = null, array $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);
    
        if ($etablissement !== null) {
            $query->whereHas('etablissement', function ($q) use ($etablissement) {
                $q->where('nom', $etablissement);
            });
        }
    
        return $query->get($columns);
    }
    // get nme grade personn
    public function getPersonnelByGrade($personnelId){
        $avancement = Avancement::where('personnel_id', $personnelId)->latest()->first();
        if ($avancement) {
            $gradeData = Grade::where('echell_debut', '<=', $avancement->echell)
                ->where('echell_fin', '>=', $avancement->echell)
                ->first();
        } else {
            $gradeData = null;
        }
        $grade = $gradeData ? $gradeData->nom : null;
        return $grade;
    }
}
