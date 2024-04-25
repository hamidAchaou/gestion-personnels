<?php

namespace App\Models\GestionParametres;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avancement extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_debut',
        'date_fin',
        'echell'
    ];
}