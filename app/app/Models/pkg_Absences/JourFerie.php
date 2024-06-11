<?php

namespace App\Models\pkg_Absences;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourFerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'is_formateur',
        'is_administrateur',
        'annee_juridique_id',
    ];


    public function anneeJuridique()
    {
        return $this->belongsTo(AnneeJuridique::class, 'annee_juridique_id');
    }
}
