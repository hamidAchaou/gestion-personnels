<?php

namespace Database\Seeders\GestionParametres;

use App\Models\GestionParametres\Ville;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villeData = [
            ['nom' => 'Tetouan'],
            ['nom' => 'Tanger'],
            ['nom' => 'Chefchaouen'],
            ['nom' => 'Fès'],
            ['nom' => 'Meknès'],
            ['nom' => 'Rabat'],
            ['nom' => 'Casablanca'],
            ['nom' => 'Marrakech'],
            ['nom' => 'Agadir'],
            ['nom' => 'Essaouira'],
            ['nom' => 'Ouarzazate'],
            ['nom' => 'Errachidia'],
            ['nom' => 'Oujda'],
            ['nom' => 'Nador'],
            ['nom' => 'El Jadida'],
            ['nom' => 'Safi'],
            ['nom' => 'Kenitra'],
            ['nom' => 'Mohammedia'],
            ['nom' => 'Taza'],
            ['nom' => 'Beni Mellal'],
            ['nom' => 'Khouribga'],
            ['nom' => 'Settat'],
            ['nom' => 'Skhirat'],
            ['nom' => 'Tan-Tan'],
            ['nom' => 'Laâyoune'],
            ['nom' => 'Dakhla'],
            ['nom' => 'Tiznit'],
            ['nom' => 'Taroudant'],
            ['nom' => 'Al Hoceima'],
            ['nom' => 'Taourirt'],
            ['nom' => 'Figuig'],
            ['nom' => 'Sefrou'],
            ['nom' => 'Tata'],
            ['nom' => 'Guelmim'],
            ['nom' => 'Sidi Ifni'],
            ['nom' => 'Kénitra'],
            ['nom' => 'Sidi Bennour'],
            ['nom' => 'Larache'],
            ['nom' => 'Zagora'],
            ['nom' => 'Khemisset'],
            ['nom' => 'Azrou'],
            ['nom' => 'Ksar El Kebir'],
            ['nom' => 'Oued Zem'],
            ['nom' => 'Midelt'],
            ['nom' => 'Berrechid'],
            ['nom' => 'Martil'],
            ['nom' => 'Fqih Ben Salah'],
            ['nom' => 'Oulad Teima'],
            ['nom' => 'Sidi Yahya El Gharb'],
            ['nom' => 'Sidi Slimane'],
            ['nom' => 'Souk Larbaa'],
            ['nom' => 'Tafraout'],
            ['nom' => 'Taliouine'],
            ['nom' => 'Youssoufia'],
            ['nom' => 'Sidi Kacem'],
            ['nom' => 'Skoura'],
            ['nom' => 'Zaio'],
            ['nom' => 'Sebta'],
            ['nom' => 'Oued Amlil'],
        ];

        foreach ($villeData as $data) {
            $cityExists = Ville::where('nom', $data['nom'])->exists();
            if (!$cityExists) {
                Ville::create($data);
            }
        }
    }
}