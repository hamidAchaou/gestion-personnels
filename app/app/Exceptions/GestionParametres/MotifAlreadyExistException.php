<?php

namespace App\Exceptions\GestionParametre;

use App\Exceptions\BusinessException;

class MotifAlreadyExistException extends BusinessException
{
    public static function createMotif()
    {
        return new self(__('GestionParametre/motif/message.createMotifException'));
    }
}