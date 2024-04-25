<?php

namespace Database\Seeders\GestionParametres;

use App\Models\GestionParametres\Avancement;
use Illuminate\Database\Seeder;

class AvancementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avancementData = [
            [
                'date_debut' => '2023-01-31',
                'date_fin' => '2024-01-31',
                'echell' => 1
            ],
            [
                'date_debut' => '2023-02-28',
                'date_fin' => '2024-02-28',
                'echell' => 2
            ],
            [
                'date_debut' => '2023-03-31',
                'date_fin' => '2024-03-31',
                'echell' => 3
            ],
            [
                'date_debut' => '2023-04-30',
                'date_fin' => '2024-04-30',
                'echell' => 4
            ],
            [
                'date_debut' => '2023-05-31',
                'date_fin' => '2024-05-31',
                'echell' => 5
            ],
            [
                'date_debut' => '2023-06-30',
                'date_fin' => '2024-06-30',
                'echell' => 6
            ],
            [
                'date_debut' => '2023-07-31',
                'date_fin' => '2024-07-31',
                'echell' => 7
            ],
            [
                'date_debut' => '2023-08-31',
                'date_fin' => '2024-08-31',
                'echell' => 8
            ],
            [
                'date_debut' => '2023-09-30',
                'date_fin' => '2024-09-30',
                'echell' => 9
            ],
            [
                'date_debut' => '2023-10-31',
                'date_fin' => '2024-10-31',
                'echell' => 10
            ],
            [
                'date_debut' => '2023-11-30',
                'date_fin' => '2024-11-30',
                'echell' => 11
            ],
            [
                'date_debut' => '2023-12-31',
                'date_fin' => '2025-12-31',
                'echell' => 12
            ],
            [
                'date_debut' => '2024-01-31',
                'date_fin' => '2025-01-31',
                'echell' => 13
            ],
            [
                'date_debut' => '2024-02-29',
                'date_fin' => '2025-02-28',
                'echell' => 14
            ],
            [
                'date_debut' => '2024-03-31',
                'date_fin' => '2025-03-31',
                'echell' => 15
            ],
            [
                'date_debut' => '2024-04-30',
                'date_fin' => '2025-04-30',
                'echell' => 16
            ],
            [
                'date_debut' => '2024-05-31',
                'date_fin' => '2025-05-31',
                'echell' => 17
            ],
            [
                'date_debut' => '2024-06-30',
                'date_fin' => '2025-06-30',
                'echell' => 18
            ],
            [
                'date_debut' => '2024-07-31',
                'date_fin' => '2025-07-31',
                'echell' => 19
            ],
            [
                'date_debut' => '2024-08-31',
                'date_fin' => '2025-08-31',
                'echell' => 20
            ],

        ];
        foreach ($avancementData as $data) {
            $AvancementExists = Avancement::where('echell', $data['echell'])->exists();
            if (!$AvancementExists) {
                Avancement::create($data);
            }
        }
    }
}
