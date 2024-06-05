<?php

namespace App\Repositories\pkg_Absences;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use App\Models\pkg_Absences\Absence;
use App\Repositories\BaseRepository;
use App\Models\pkg_Absences\JourFerie;
use Illuminate\Database\Eloquent\Builder;
use App\Models\pkg_Absences\AnneeJuridique;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
    protected $fieldsSearchable = ['name'];

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

    public function filterByMotif(string $motifNom, $perPage = 2)
    {
        return $this->model
            ->with(['personnel', 'motif'])
            ->whereHas('motif', function (Builder $query) use ($motifNom) {
                $query->where('nom', 'LIKE', '%' . $motifNom . '%');
            })
            ->paginate($perPage);
    }

    public function filterByDateRange(string $startDate, string $endDate, $perPage = 2)
    {
        // Convert the date strings to Carbon instances for comparison
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $this->model
            ->with(['personnel', 'motif'])
            ->whereBetween('date_debut', [$start, $end])
            ->orWhereBetween('date_fin', [$start, $end])
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        // $AbsenceUserId = $this->allQuery(['user_id' => $data["user_id"]])->get();
        // $personnel = User::where('id', $data["user_id"])->pluck('id')->first();

        // // Check if the personnel ID exists
        // if (!$personnel) {
        //     throw new \Exception("No personnel found.");
        // }
        // dd($personnel);

        // $anneeJuridique = $this->convertToAnneeJuridique($data["date_debut"]);
        // $anneeJuridiqueId = AnneeJuridique::where("annee", $anneeJuridique)->pluck('id')->first();
        // // Check if the AnneeJuridique ID exists
        // if (!$anneeJuridiqueId) {
        //     throw new \Exception("No matching AnneeJuridique found.");
        // }
        // $jour_feries = JourFerie::where("annee_juridique_id", $anneeJuridiqueId)->get();
        // dd($jour_feries);

        return parent::create($data);
    }

    public function getAbsencesWithRelations($perPage = 4)
    {
        // Subquery to get the IDs of the last absences for each personnel
        $subquery = $this->model->selectRaw('MAX(id) as max_id')->groupBy('user_id');

        // Main query to fetch the absences with relations using the subquery
        return $this->model
            ->whereIn('id', function ($query) use ($subquery) {
                $query->fromSub($subquery, 'subquery');
            })
            ->with('personnel', 'motif')
            ->paginate($perPage);
    }

    public function exportAbsenceWithRelations()
    {
        return $this->model->with('personnel', 'motif')->get();
    }

    public function getAbsencesPersonnel($matricule, $perPage = 4)
    {
        return $this->model
            ->whereHas('personnel', function ($query) use ($matricule) {
                $query->where('matricule', $matricule);
            })
            ->with('personnel', 'motif')
            ->paginate($perPage);
    }

    public function filterForDocument(string $startDate, string $endDate, array $motifs)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $this->model
            ->with(['personnel', 'motif'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('date_debut', [$start, $end])
                    ->orWhereBetween('date_fin', [$start, $end]);
            })
            ->whereIn('motif_id', $motifs)
            ->get();
    }


    /**
     * Recherche les projets correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(string $searchableData, int $perPage = 4)
    {
        // Subquery to get the IDs of the last absences for each personnel
        $subquery = $this->model->selectRaw('MAX(id) as max_id')->groupBy('user_id');

        // Main query to fetch the absences with relations using the subquery and applying search
        $query = $this->model
            ->whereIn('id', function ($query) use ($subquery) {
                $query->fromSub($subquery, 'subquery');
            })
            ->whereHas('personnel', function ($q) use ($searchableData) {
                $q->where('nom', 'like', "%$searchableData%");
            })
            ->with(['personnel', 'motif']);

        return $query->paginate($perPage);
    }
}
