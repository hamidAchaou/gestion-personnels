<?php

namespace App\Repositories\pkg_PriseDeServices\Personnel;

use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\BaseRepositorie;
use Illuminate\Database\Eloquent\Model;

class PersonnelRepository extends BaseRepositorie
{
    protected $model;

    public function __construct(Personnel $user)
    {
        $this->model = $user;
    }
}
