<?php

namespace App\Repositories\GestionPriseDeService;

use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\BaseRepositorie;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\GestionPriseDeService\Personnel\PersonnelAlreadyExistException;

class PersonnelRepository extends BaseRepositorie
{
    protected $model;

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
    public function searchData($searchableData, $perPage = 4)
    {
        return $this->model->where(function ($query) use ($searchableData) {
            $query->where('nom', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }
    public function paginate($perPage = 6){
        $query = $this->model->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', '!=', 'admin')
            ->select('users.*');
    
        return $query->paginate($perPage);
    }
}
