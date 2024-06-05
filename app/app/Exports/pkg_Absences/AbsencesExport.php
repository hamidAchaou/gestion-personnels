<?php

namespace App\Exports\pkg_Absences;

use App\Models\pkg_Absences\Absence;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\helpers\pkg_Absences\AbsenceHelper;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsencesExport  implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function headings(): array{
        return [
            'Matricule',
            'Personnels',
            'Motif',
            'Date debut',
            'Date fin',
            'Durée absence',
            'remarques',
        ];
    }

    public function collection()
    {

        // Transform the data before exporting
        return $this->data->map(function ($absence) {
            return [
                'Matricule' => $absence->personnel->matricule,
                'Personnels' => $absence->personnel->nom . ' ' . $absence->personnel->prenom,
                'Motif' => $absence->motif->nom,
                'Date debut' => $absence->date_debut,
                'Date fin' => $absence->date_fin,
                'Durée absence' => AbsenceHelper::calculateAbsenceDurationForPersonnel($absence),
                'remarques' => $absence->remarques,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
