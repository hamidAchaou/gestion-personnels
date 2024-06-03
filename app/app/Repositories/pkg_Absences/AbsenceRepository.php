<?php

namespace App\Repositories\pkg_Absences;

use App\Models\pkg_Absences\Absence;
use App\Models\pkg_Absences\AnneeJuridique;
use App\Models\pkg_Absences\JourFerie;
use App\Models\User;
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


    public function create(array $data)
    {


        $AbsenceUserId = $this->allQuery(['user_id' => $data["user_id"]])->get();
        $personnel = User::where('id', $data["user_id"])->pluck('id')->first();

        // Check if the personnel ID exists
        if (!$personnel) {
            throw new \Exception("No personnel found.");
        }
        dd($personnel);


        $anneeJuridique = $this->convertToAnneeJuridique($data["date_debut"]);
        $anneeJuridiqueId = AnneeJuridique::where("annee", $anneeJuridique)->pluck('id')->first();
        // Check if the AnneeJuridique ID exists
        if (!$anneeJuridiqueId) {
            throw new \Exception("No matching AnneeJuridique found.");
        }
        $jour_feries = JourFerie::where("annee_juridique_id", $anneeJuridiqueId)->get();
        dd($jour_feries);


        return parent::create($data);
    }

    private function convertToAnneeJuridique($date)
    {
        $carbonDate = Carbon::parse($date);
        $year = $carbonDate->year;
        $month = $carbonDate->month;

        if ($month > 6) {
            // If the month is after June, the legal year is current year to next year
            $anneeJuridique = $year . '-' . ($year + 1);
        } else {
            // If the month is before or in June, the legal year is previous year to current year
            $anneeJuridique = ($year - 1) . '-' . $year;
        }

        return $anneeJuridique;
    }

}
