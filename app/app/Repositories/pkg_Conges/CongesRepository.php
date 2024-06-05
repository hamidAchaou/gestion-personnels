<?php

namespace App\Repositories\pkg_Conges;

use App\Exceptions\pkg_conges\CongeAlreadyExistException;
use App\Models\pkg_Conges\Conge;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CongesRepository extends BaseRepository
{
    /**
     * Constructeur de la classe CongesRepository.
     *
     * @param Conge $model
     */
    public function __construct(Conge $model)
    {
        parent::__construct($model);
    }

    /**
     * Renvoie les champs recherchables pour le modèle Conges.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return [
            'id',
            'date_debut',
            'date_fin',
            'motif_id',
        ];
    }

    public function paginate($search = [], $perPage = 0, array $columns = ['*']): LengthAwarePaginator
    {
        if ($perPage == 0) {
            $perPage = $this->paginationLimit;
        }

        return $this->model
            ->with(['motif', 'personnels'])
            ->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        $personnel_id = $data['personnel_id'];
        $date_debut = $data['date_debut'];
        $date_fin = $data['date_fin'];

        // Check if the user already has the conge associated with them
        $existingConge = Conge::whereHas('personnels', function ($query) use ($personnel_id, $date_debut, $date_fin) {
            $query->where('personnel_id', $personnel_id)
                ->where('date_debut', '<=', $date_fin)
                ->where('date_fin', '>=', $date_debut);
        })->exists();

        if ($existingConge) {
            throw new CongeAlreadyExistException();
        } else {
            $conge = parent::create($data);
            $conge->personnels()->attach($data['personnel_id']);
            return $conge;
        }
    }

    public function update($id, array $data)
    {
        // $personnel_id = $data['personnel_id'];

        // Find the Conge instance by ID
        $conge = $this->model->find($id);

        if (!$conge) {
            return false;
        }

        $conge->update($data);

        // if ($personnel_id != $conge->personnels()->first()->pivot->personnel_id) {
        //     $conge->personnels()->detach(); // Detach current user
        //     $conge->personnels()->attach($data['personnel_id']); // Attach new user
        // }

        return $conge;
    }

    public function destroy($id)
    {
        $conge = $this->model->findOrFail($id);
        $conge->personnels()->detach();
        return $conge->delete();
    }

    // public function searchData($searchableData, $perPage = 0)
    // {
    //     if ($perPage == 0) {
    //         $perPage = $this->paginationLimit;
    //     }

    //     return $this->model
    //         ->where(function ($query) use ($searchableData) {
    //             $query->whereHas('personnels', function ($q) use ($searchableData) {
    //                 $q->where('nom', 'like', '%' . $searchableData . '%')
    //                     ->orWhere('prenom', 'like', '%' . $searchableData . '%')
    //                     ->orWhere('matricule', 'like', '%' . $searchableData . '%');
    //             })
    //             ->orWhere('date_debut', 'like', '%' . $searchableData . '%')
    //             ->orWhere('date_fin', 'like', '%' . $searchableData . '%');
    //         })
    //         ->paginate($perPage);
    // }


    /**
     * Filter Conges by date or year.
     *
     * @param string|null $date_debut Start date for filtering conges.
     * @param string|null $date_fin End date for filtering conges.
     * @param int|null $year Year for filtering conges.
     * @return \Illuminate\Database\Eloquent\Collection Collection of filtered conges.
     */
    public function filterByDate(string $date_debut = null, string $date_fin = null, int $year = null)
    {
        return $this->model
            ->where(function ($query) use ($date_debut, $date_fin, $year) {
                if ($date_debut && $date_fin) {
                    $query->whereBetween('date_debut', [$date_debut, $date_fin])
                        ->orWhereBetween('date_fin', [$date_debut, $date_fin]);
                } elseif ($year) {
                    $query->whereYear('date_debut', $year)
                        ->orWhereYear('date_fin', $year);
                }
            })
            ->get();
    }


    /**
     * Get all Conges for a given Personnel ID with optional search.
     *
     * @param string|null $searchValue Search term for personnel name, surname, or matricule.
     * @param int|null $personnelId ID of the personnel to filter the conges.
     * @param string|null $date_debut Start date for filtering conges.
     * @param string|null $date_fin End date for filtering conges.
     * @param int $perPage Number of results per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of conges.
     */
    public function searchData($searchableData = null, $date_debut = null, $date_fin = null, $perPage = 0, $personnel_id = null)
    {
        if ($perPage == 0) {
            $perPage = $this->paginationLimit;
        }

        return $this->model
            ->where(function ($query) use ($searchableData, $date_debut, $date_fin, $personnel_id) {
                if ($personnel_id !== null) {
                    $query->where('personnel_id', $personnel_id);
                }

                if ($searchableData !== null) {
                    $query->whereHas('personnels', function ($q) use ($searchableData) {
                        $q->where('nom', 'like', '%' . $searchableData . '%')
                            ->orWhere('prenom', 'like', '%' . $searchableData . '%')
                            ->orWhere('matricule', 'like', '%' . $searchableData . '%');
                    })
                        ->orWhere('date_debut', 'like', '%' . $searchableData . '%')
                        ->orWhere('date_fin', 'like', '%' . $searchableData . '%');
                }

                if ($date_debut !== null && $date_fin !== null) {
                    $query->whereBetween('date_debut', [$date_debut, $date_fin]);
                }
            })
            ->paginate($perPage);
    }

    /**
     * Get all Conges for a given Personnel ID with optional search
     *
     * @param string|null $searchValue
     * @param int $personnelId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCongesByPersonnelId(?string $searchValue, int $personnelId, $perPage = 0)
    {
        $query = Conge::whereHas('personnels', function ($query) use ($personnelId) {
            $query->where('personnel_id', $personnelId);
        });

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('date_debut', 'LIKE', "%{$searchValue}%")
                    ->orWhere('date_fin', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('motif', function ($query) use ($searchValue) {
                        $query->where('nom', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        return $query->paginate(6);
    }
}
