<?php

namespace App\Models\GestionPersonnels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\pkg_Parametres\Etablissement;
use App\Models\pkg_Parametres\Fonction;
use App\Models\pkg_Parametres\Specialite;
use App\Models\pkg_Parametres\Ville;
use App\Models\pkg_Parametres\Avancement;
use App\Models\pkg_Absences\Absence;
use App\Models\pkg_Conges\Conge;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'nom_arab',
        'prenom_arab',
        'cin',
        'date_naissance',
        'telephone',
        'email',
        'password',
        'address',
        'images',
        'matricule',
        'ville_id',
        'fonction_id',
        'grade_id',
        'specialite_id',
        'etablissement_id',
        'avancement_id',
    ];
    public function ville(){
        return $this->belongsTo(Ville::class,'ville_id'); 
    }
    public function fonction(){
        return $this->belongsTo(Fonction::class,'fonction_id'); 
    }
    public function specialite(){
        return $this->belongsTo(Specialite::class,'specialite_id'); 
    }
    public function etablissement(){
        return $this->belongsTo(Etablissement::class,'etablissement_id'); 
    }
    public function avancement(){
        return $this->belongsTo(Avancement::class,'avancement_id');
    }
    public function absences()
    {
        return $this->belongsToMany(Absence::class);
    }
    public function conges()
    {
        return $this->belongsToMany(Conge::class, 'personnels_conges', 'user_id', 'conges_id')->withTimestamps();
    }
}
