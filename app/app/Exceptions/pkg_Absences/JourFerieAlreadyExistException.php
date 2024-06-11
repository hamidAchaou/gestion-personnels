<?php

namespace App\Exceptions\pkg_Absences;

use Exception;

class JourFerieAlreadyExistException extends Exception
{
    public static function create()
    {
        return new self(__('pkg_Absences/jourFerie.JourFerieAlreadyExistException'));
    }
}
