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

    // Filter By date 
    public function filterByDate($date_debut, $date_fin)
    {
        return $this->model
            ->where(function ($query) use ($date_debut, $date_fin) {
                $query->whereBetween('date_debut', [$date_debut, $date_fin]);
                // ->orWhereBetween('date_fin', [$date_debut, $date_fin]);
            })
            ->get();
    }


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

    public function searchDataOnePersonnel($searchableData = null, $personnel_id = null, $perPage = 0)
{
    if ($perPage == 0) {
        $perPage = $this->paginationLimit;
    }

    return $this->model
        ->whereHas('personnels', function ($query) use ($searchableData, $personnel_id) {
            if ($personnel_id !== null) {
                $query->where('personnel_id', $personnel_id);
            }

            if ($searchableData !== null) {
                $query->where(function ($q) use ($searchableData) {
                    $q->where('nom', 'like', '%' . $searchableData . '%')
                      ->orWhere('prenom', 'like', '%' . $searchableData . '%')
                      ->orWhere('matricule', 'like', '%' . $searchableData . '%');
                });
            }
        })
        ->when($searchableData, function ($query) use ($searchableData) {
            $query->orWhere('date_debut', 'like', '%' . $searchableData . '%')
                  ->orWhere('date_fin', 'like', '%' . $searchableData . '%');
        })
        ->paginate($perPage);
}

    



    // public function searchData($searchableData = null, $date_debut = null, $date_fin = null, $perPage = 0)
    // {
    //     if ($perPage == 0) {
    //         $perPage = $this->paginationLimit;
    //     }

    //     return $this->model
    //         ->where(function ($query) use ($searchableData, $date_debut, $date_fin) {
    //             if ($searchableData !== null) {
    //                 $query->whereHas('personnels', function ($q) use ($searchableData) {
    //                     $q->where('nom', 'like', '%' . $searchableData . '%')
    //                         ->orWhere('prenom', 'like', '%' . $searchableData . '%')
    //                         ->orWhere('matricule', 'like', '%' . $searchableData . '%');
    //                 })
    //                     ->orWhere('date_debut', 'like', '%' . $searchableData . '%')
    //                     ->orWhere('date_fin', 'like', '%' . $searchableData . '%');
    //             }

    //             if ($date_debut !== null && $date_fin !== null) {
    //                 $query->whereBetween('date_debut', [$date_debut, $date_fin]);
    //             }
    //         })
    //         ->paginate($perPage);
    // }
}
