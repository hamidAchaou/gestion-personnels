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
    public function paginate($search = [], $perPage = 0, array $columns = ['*']): LengthAwarePaginator
    {
        if ($perPage == 0) {
            $perPage = $this->paginationLimit;
        }

        $query = $this->allQuery($search);

        // Join with the users table to get the personnel name
        $query->join('users', 'users.id', '=', 'avancements.personnel_id')
            ->join('grades', function ($join) {
                $join->on('grades.echell_debut', '<=', 'avancements.echell')
                    ->where('grades.echell_fin', '>=', 'avancements.echell');
            })->select('avancements.*', DB::raw("CONCAT(users.nom, ' ', users.prenom) as personnel_name"), 'grades.nom as grade_name');

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
    public function searchData($searchableData, $perPage = 4)
    {
        return $this->model->where(function ($query) use ($searchableData) {
            $query->where('echell', 'like', '%' . $searchableData . '%')
                ->orWhere('personnel_id', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }

}
