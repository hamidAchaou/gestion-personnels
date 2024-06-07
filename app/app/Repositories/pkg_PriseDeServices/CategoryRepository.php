<?php 

namespace App\Repositories\pkg_PriseDeServices;

use App\Repositories\BaseRepository;
use App\Models\pkg_Parametres\Avancement;
use App\Exceptions\pkg_PriseDeServices\CategoryAlreadyExistException;

class CategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'date_debut',
        'date_fin',
        'echell'
    ];

    public function getFieldsSearchable():array{
       return $this->fieldSearchable;
    }
    public function __construct(Avancement $avancement){
        $this->model = $avancement;
    }
    public function create(array $data){
        $personne_id = $data['personnel_id'];
        $echell = $data['echell'];
        $existCategory = Avancement::where([
            ['personnel_id', '=', $personne_id],
            ['echell', '=', $echell]
        ])->exists();
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
                ->orWhere('prenom', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }

}
