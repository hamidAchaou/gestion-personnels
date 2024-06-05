@extends('layouts.app')
@section('title', __('pkg_Absences/Absence.singular'))

@section('content')
    <section class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Historique des absences</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{route('absence.index')}}" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>
                        Retoure</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-purple card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/user.png') }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $absencesPersonnel[0]->personnel->nom }}
                                {{ $absencesPersonnel[0]->personnel->prenom }}</h3>
                            <p class="text-muted text-center">Formateur</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Matricule</b> <a
                                        class="float-right text-purple">{{ $absencesPersonnel[0]->personnel->matricule }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Etablissement</b> <a class="float-right text-purple">{{$etablissment}}</a>
                                </li>
                                {{-- <li class="list-group-item">
                                    <b>Jours restant</b> <a class="float-right text-purple">6</a>
                                </li> --}}
                            </ul>
                            <a href="/view/personnels/show.php" class="btn bg-purple btn-block"
                                style="margin-top: 2rem"><b>Plus
                                    d'informations</b></a>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-purple card-outline">
                                        <div class="card-header col-md-12">
                                            <div class="row justify-content-between">
                                                <!-- filter by start date / end date -->
                                                <div class="col-md-9 row">
                                                    <div class="input-group-sm input-group col-md-4">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-default">
                                                                <i class="fas fa-filter"></i>
                                                            </button>
                                                        </div>
                                                        <select class="form-select form-control"
                                                            id="filterSelectProjrctValue" aria-label="Filter Select">
                                                            <option value="précédent">année</option>
                                                            <option value="précédent">2024</option>
                                                            <option value="précédent">2023</option>
                                                            <option value="précédent">2022</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="d-flex justify-content-end">

                                                        <div class=" p-0">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" name="table_search"
                                                                    class="form-control" placeholder="Recherche">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-default">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-striped text-nowrap table-print">
                                                <thead>
                                                    <tr>
                                                        <th>Matricule</th>
                                                        <th>Motif</th>
                                                        <th>Date de début</th>
                                                        <th>Date de fin</th>
                                                        <th class="text-center">Durée absence</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($absencesPersonnel as $absence)
                                                        <tr>
                                                            <td>{{ $absence->personnel->matricule }}</td>
                                                            <td>{{ $absence->motif->nom }}</td>
                                                            <td class="text-center">{{ $absence->date_debut }}</td>
                                                            <td class="text-center">{{ $absence->date_fin }}</td>
                                                            <td class="text-center">
                                                                {{ App\Helpers\pkg_Absences\AbsenceHelper::calculateAbsenceDurationForPersonnel($absence) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{route('absence.edit', $absence)}}" class="btn btn-sm btn-default"><i
                                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                                <form action="{{ route('absence.destroy', $absence->id) }}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Absence ?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7">Aucune absence ñ'a</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row justify-content-between p-2">
                                            <div class="col-6 align-self-end">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                    IMPORTER</button>
                                                <button type="button" class="btn btn-default btn-sm ">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    EXPORTER</button>
                                            </div>
                                            <div class="col-6">
                                                <ul class="pagination  m-0 float-right">
                                                    {{ $absencesPersonnel->onEachSide(1)->links() }}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

            </div>

        </div>
    </section>

@endsection
