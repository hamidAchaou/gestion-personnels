<?php

namespace App\Models\GestionPersonnels;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description'
    ];
    public function personnel(){
        return $this->hasMany(User::class,'etablissement_id');
    }
}
