<?php

namespace App\Models\GestionParametre;

use App\Models\GestionConges\Conge;
use App\Models\GestionPersonnels\Personnel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
    ];

    public function conge()
    {
        return $this->hasMany(Conge::class, 'motif_id');
    }
}
