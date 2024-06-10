<?php

namespace App\Repositories\pkg_PriseDeServices;

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

        $query = $this->allQuery($search);

        $query->join('users', 'users.id', '=', 'avancements.personnel_id')
            ->join('grades', function ($join) {
                $join->on('grades.echell_debut', '<=', 'avancements.echell')
                    ->where('grades.echell_fin', '>=', 'avancements.echell');
            })
            ->join('etablissements', 'users.etablissement_id', '=', 'etablissements.id')
            ->select('avancements.*', DB::raw("CONCAT(users.nom, ' ', users.prenom) as personnel_name"), 'grades.nom as grade_name');

        if (!empty($etablissement)) {
            $query->where('etablissements.nom', '=', $etablissement);
        }

        return $query->paginate($perPage, $columns);
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

        $records = DB::table('gestion_personnels.avancements')
            ->join('gestion_personnels.users', 'gestion_personnels.users.id', '=', 'gestion_personnels.avancements.personnel_id')
            ->join('gestion_personnels.grades', function ($join) {
                $join->on('gestion_personnels.grades.echell_debut', '<=', 'gestion_personnels.avancements.echell')
                    ->where('gestion_personnels.grades.echell_fin', '>=', 'gestion_personnels.avancements.echell');
            })
            ->select(
                'gestion_personnels.avancements.*',
                DB::raw("CONCAT(gestion_personnels.users.nom, ' ', gestion_personnels.users.prenom) as personnel_name"),
                'gestion_personnels.users.matricule',
                'gestion_personnels.grades.nom as grade' // Corrected syntax for selecting the 'grades.nom' column
            )
            ->where('gestion_personnels.avancements.personnel_id', $userId)
            ->get();

        if ($records->isEmpty()) {
            // Handle the case where no records are found
            abort(404, 'No records found for the specified user in the given establishment');
        }

        // dd($records);
        if ($records->isEmpty()) {
            // Handle the case where no records are found
            abort(404, 'No records found for the specified user in the given establishment');
        }

        return $records;
    }






}
