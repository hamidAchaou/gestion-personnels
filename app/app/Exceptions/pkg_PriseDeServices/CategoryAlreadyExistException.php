<?php

namespace App\Exceptions\pkg_PriseDeServices;

use App\Exceptions\BusinessException;

class CategoryAlreadyExistException extends BusinessException
{
    public static function createCategory()
    {
        return new self(__('La categorie existe déjà'));
    }
}
