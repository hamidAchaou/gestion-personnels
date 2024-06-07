<?php

namespace App\Models\pkg_Parametres;

use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avancement extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_debut',
        'date_fin',
        'echell',
        'personnel_id'
    ];
    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}