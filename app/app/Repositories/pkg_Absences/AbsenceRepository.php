<?php

namespace App\Repositories\pkg_Absences;

use App\Models\pkg_Absences\Absence;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
/**
 * Classe ProjetRepository qui gère la persistance des projets dans la base de données.
 */
class AbsenceRepository extends BaseRepository
{
    /**
     * Les champs de recherche disponibles pour les projets.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'name'
    ];

    /**
     * Renvoie les champs de recherche disponibles.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldsSearchable;
    }

    /**
     * Constructeur de la classe ProjetRepository.
     */
    public function __construct()
    {
        parent::__construct(new Absence());
    }

    /**
     * Filtre les absences par le nom du motif.
     *
     * @param string $motifNom Le nom du motif pour filtrer les absences.
     * @return Collection La collection des absences filtrées par le motif.
     */
    public function filterByMotif(string $motifNom): Collection
    {
        try {
            return $this->model->whereHas('motif', function (Builder $query) use ($motifNom) {
                $query->where('nom', 'LIKE', '%' . $motifNom . '%');
            })->get();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error filtering by motif: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Filtre les absences par une plage de dates.
     *
     * @param string $startDate Date de début au format 'Y-m-d'.
     * @param string $endDate Date de fin au format 'Y-m-d'.
     * @return Collection La collection des absences filtrées par la plage de dates.
     */
    public function filterByDateRange(string $startDate, string $endDate): Collection
    {
        try {
            // Convert the date strings to Carbon instances for comparison
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            return $this->model->whereBetween('date_debut', [$start, $end])
                ->orWhereBetween('date_fin', [$start, $end])
                ->get();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error filtering by date range: ' . $e->getMessage(), 0, $e);
        }
    }
}
