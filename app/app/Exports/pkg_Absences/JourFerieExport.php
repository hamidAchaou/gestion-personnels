<?php

namespace App\Exports\pkg_Absences;

use App\Models\pkg_Absences\JourFerie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\helpers\pkg_Absences\AbsenceHelper;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JourFerieExport  implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function headings(): array{
        return [
            'Année juridique',
            'Nom',
            'Formateur',
            'Administrateur',
            'Date debut',
            'Date fin',
        ];
    }

    public function collection()
    {

        // Transform the data before exporting
        return $this->data->map(function ($jourFerie) {
            return [
                'Année juridique' => $jourFerie->anneeJuridique->annee,
                'Nom' => $jourFerie->nom,
                'Formateur' => $jourFerie->is_formateur ? true : false,
                'Administrateur' => $jourFerie->is_administrateur ? true : false,
                'Date debut' => $jourFerie->date_fin,
                'Date fin' => $jourFerie->date_fin,
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
