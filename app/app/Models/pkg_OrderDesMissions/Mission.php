<?php

namespace App\Models\pkg_OrderDesMissions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\pkg_OrderDesMissions\MoyensTransport;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_mission',
        'nature',
        'lieu',
        'type_de_mission',
        'numero_ordre_mission',
        'data_ordre_mission',
        'date_debut',
        'date_fin',
        'date_depart',
        'heure_de_depart',
        'date_return',
        'heure_de_return',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'mission_personnel', 'user_id', 'mission_id');
    }

    public function moyensTransport()
    {
        return $this->belongsToMany(MoyensTransport::class, 'transports', 'mission_id', 'moyens_transports_id')->withTimestamps();
    }
}