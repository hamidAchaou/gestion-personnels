<?php

namespace Database\Seeders\GestionParametres;

use App\Models\GestionParametres\Fonction;
use Illuminate\Database\Seeder;

class FonctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fonctionData = [
            [
                'nom' => 'Formateur',
                'description' => '',
            ],
            [
                'nom' => 'Administrateur',
                'description' => ''
            ]
        ];
        foreach ($fonctionData as $data) {
            $fonctionExists = Fonction::where('nom', $data['nom'])->exists();
            if (!$fonctionExists) {
                Fonction::create($data);
            }
        }
    }
}
