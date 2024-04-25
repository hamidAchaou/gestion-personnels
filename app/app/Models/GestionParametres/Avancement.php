<?php

namespace App\Models\GestionPersonnels;

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

    public function personnel(){
        return $this->hasMany(User::class,'avancement_id');
    }
}
