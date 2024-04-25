<?php

namespace App\Models\GestionParametre;

use App\Models\GestionPersonnels\Personnel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description'
    ];
    public function personnel(){
        return $this->hasMany(Personnel::class,'fonction_id');
    }
}
