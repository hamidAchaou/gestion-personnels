<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositorieInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepositorie implements RepositorieInterface
{

    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function paginate($pages = 6){
        return $this->model->paginate($pages);
    }

    public function find($id){
        return $this->model->find($id);
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);

        if (!$record) {
            return false;
        }

        return $record->update($data);
    }

    public function destroy($id){
        $record = $this->model->find($id);
        return $record->delete();
    }
}