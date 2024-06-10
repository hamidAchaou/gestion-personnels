<?php

namespace App\Repositories\pkg_PriseDeServices;

use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\BaseRepository;
use App\Models\pkg_Parametres\Avancement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\pkg_PriseDeServices\CategoryAlreadyExistException;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'date_debut',
        'date_fin',
        'echell'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }
    public function __construct(Avancement $avancement)
    {
        $this->model = $avancement;
    }

    /**
     * Override paginate method to include personnel name concatenation.
     *
     * @param array|string $search
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($etablissement = "", $search = [], $perPage = 0, array $columns = ['*']): LengthAwarePaginator
{
    if ($perPage == 0) {
        $perPage = $this->paginationLimit;
    }

    $latestAvancementsSubquery = DB::table('avancements')
        ->select('avancements.*')
        ->whereIn('avancements.id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('avancements')
                ->groupBy('personnel_id');
        });

    $query = $this->allQuery($search)
        ->joinSub($latestAvancementsSubquery, 'latest_avancements', function ($join) {
            $join->on('latest_avancements.personnel_id', '=', 'avancements.personnel_id');
        })
        ->join('users', 'users.id', '=', 'latest_avancements.personnel_id')
        ->join('etablissements', 'users.etablissement_id', '=', 'etablissements.id')
        ->select('latest_avancements.*', DB::raw("CONCAT(users.nom, ' ', users.prenom) as personnel_name"), 'etablissements.nom as etablissement_name')
        ->distinct();

    if (!empty($etablissement)) {
        $query->where('etablissements.nom', '=', $etablissement);
    }

    $avancements = $query->paginate($perPage, $columns);

    $avancements->getCollection()->transform(function ($avancement) {
        $grade = DB::table('grades')
            ->where('grades.echell_debut', '<=', $avancement->echell)
            ->where('grades.echell_fin', '>=', $avancement->echell)
            ->first();

        $avancement->grade_name = $grade->nom ?? null;

        return $avancement;
    });

    return $avancements;
}

    

    public function create(array $data)
    {
        $personne_id = $data['personnel_id'];
        $personnelEchellExsit = Avancement::where('personnel_id', $data['personnel_id'])->latest()->first();
        $echell = $data['echell'];
        $existCategory = Avancement::where([
            ['personnel_id', '=', $personne_id],
            ['echell', '=', $echell]
        ])->exists();

        if ($personnelEchellExsit && !$existCategory) {
            $this->update($personnelEchellExsit->id, ['date_fin' => now()]);
        }
        if ($existCategory) {
            throw CategoryAlreadyExistException::createCategory();
        } else {
            return parent::create($data);
        }

    }
    /**
     * Recherche les categories correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchData($etablissement, $searchableData = null, $date_debut = null, $date_fin = null, $perPage = 0, $personnel_id = null)
    {

        $query = $this->model->join('users', 'users.id', '=', 'avancements.personnel_id')
            ->join('etablissements', 'users.etablissement_id', '=', 'etablissements.id')
            ->where('etablissements.nom', '=', $etablissement)
            ->select('avancements.*', DB::raw("CONCAT(users.nom, ' ', users.prenom) as personnel_name"));

        if (!empty($searchableData)) {
            $query->where(function ($query) use ($searchableData) {
                $query->where('users.nom', 'like', '%' . $searchableData . '%')
                    ->orWhere('users.prenom', 'like', '%' . $searchableData . '%');
            });
        }

        if (!empty($date_debut)) {
            $query->whereDate('avancements.date_debut', '>=', $date_debut)
                ->where('grades.echell_fin', '>=', 'avancements.echell');
        }

        if (!empty($date_fin)) {
            $query->whereDate('avancements.date_fin', '<=', $date_fin);
        }

        if (!empty($personnel_id)) {
            $query->where('avancements.personnel_id', '=', $personnel_id);
        }

        if ($perPage == 0) {
            $perPage = $this->paginationLimit;
        }

        return $query->paginate($perPage);
    }
    public function find(int $id, array $columns = ['*'])
    {
        $user = $this->model->find($id);
        $userId = $user->personnel_id;
        $personnelData = Personnel::where('id', $userId)->first();

        $records = DB::table('gestion_personnels.avancements')
            ->join('gestion_personnels.users', 'gestion_personnels.users.id', '=', 'gestion_personnels.avancements.personnel_id')
            ->join('gestion_personnels.etablissements', 'gestion_personnels.users.etablissement_id', '=', 'gestion_personnels.etablissements.id')
            ->select(
                'gestion_personnels.avancements.id',
                'gestion_personnels.avancements.date_debut',
                'gestion_personnels.avancements.date_fin',
                'gestion_personnels.avancements.echell',
                'gestion_personnels.avancements.personnel_id',
                'gestion_personnels.users.matricule',
                'gestion_personnels.etablissements.nom as etablissement_name',
                DB::raw("CONCAT(gestion_personnels.users.nom, ' ', gestion_personnels.users.prenom) as personnel_name")
            )
            ->where('gestion_personnels.avancements.personnel_id', $userId)
            ->distinct() 
            ->get();

        if ($records->isEmpty()) {
            abort(404, 'No records found for the specified user in the given establishment');
        }

        $records->each(function ($record) {
            $grade = DB::table('gestion_personnels.grades')
                ->where('echell_debut', '<=', $record->echell)
                ->where('echell_fin', '>=', $record->echell)
                ->select('nom as grade_name')
                ->first();

            $record->grade_name = $grade ? $grade->grade_name : null;
        });

        return [
            'personnelData' => $personnelData,
            'records' => $records,
        ];
    }


}
