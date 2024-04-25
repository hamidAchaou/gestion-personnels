<?php

namespace Database\Seeders\GestionParametres;

use App\Models\GestionParametres\Specialite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialiteData = [
            [
                'nom' => 'Développeur',
                'description' => '',
            ],
            [
                'nom' => 'comptable',
                'description' => ''
            ]
        ];
        foreach ($specialiteData as $data) {
            $specialiteExists = Specialite::where('nom', $data['nom'])->exists();
            if (!$specialiteExists) {
                Specialite::create($data);
            }
        }
    }
}