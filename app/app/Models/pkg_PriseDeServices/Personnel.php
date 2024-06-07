<?php

namespace App\Models\pkg_PriseDeServices;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends User
{
    use HasFactory;
    protected $table = 'users';
}
