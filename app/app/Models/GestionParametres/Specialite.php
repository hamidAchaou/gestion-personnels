<?php

namespace App\Models\GestionPersonnels;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];
    public function personnel(){
        return $this->hasMany(User::class,'specialite_id');
    }
}
