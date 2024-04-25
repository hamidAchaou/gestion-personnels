<?php

namespace Database\Seeders\GestionPersonnels;

use App\Models\GestionPersonnels\Etablissement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etablissementData = [
            [
                'nom' => 'Solicode',
                'description' => 'SOLICODE est un centre de formation solidaire et inclusif, ouvert aux jeunes motivés et intéressés par les métiers du Développement Web et Mobile.',
            ],
            [
                'nom' => 'ISTA NTIC',
                'description' => 'L’Institut Spécialisé dans les Métiers de l’Offshoring et les Nouvelles Technologies de l’Information et de la Communication (ISMONTIC) de Tanger est un établissement supérieur relevant de l’Office de la Formation Professionnelle et de la Formation de Travail (OFPPT).

                L’ISMONTIC a pour mission de former, au meilleur niveau international, de véritables professionnels maîtrisant les techniques informatiques d’aujourd’hui, aptes à assimiler celles de demain et à innover dans ce domaine sans cesse en évolution et qui offre un large spectre de métiers.',
            ],
            [
                'nom' => 'ISTA Ibn Marhal',
                'description' => 'Institut Spécialisé de Technologie Appliquée Ibn Marhal Tanger',
            ],
            [
                'nom' => 'CNMH',
                'description' => 'Centre National Mohamed VI des Handicapés',
            ],

        ];
        foreach ($etablissementData as $data) {
            $EtablissementExists = Etablissement::where('nom', $data['nom'])->exists();
            if (!$EtablissementExists) {
                Etablissement::create($data);
            }
        }
    }
}