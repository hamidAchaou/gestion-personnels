@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Historique des missions</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('missions.index') }}" class="btn btn-default float-right"><i
                            class="fas fa-arrow-left"></i>
                        Retoure</a>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body col-sm-12 col-lg d-flex ">
                            <fieldset class="border col-lg-12 mb-5 p-3">
                                <legend>Liste des Personnel</legend>
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Matricule</th>
                                                <th>Personnel</th>
                                                <th>Catégorie</th>
                                                <th>État</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mission->users as $user)
                                                <tr>
                                                    <td>{{ $user->matricule }}</td>
                                                    <td>{{ $user->nom }}</td>
                                                    <td>{{ $user->avancement->echell }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('missions.show', $user->id) }}"
                                                            class='btn btn-default btn-sm'>
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                        <div class="card-body row">
                            <div class="col-sm-12 col-lg d-flex">
                                <fieldset class="border col-lg-12 mb-5 p-3">
                                    <legend>Les Informations de mission</legend>
                                    <!-- Numéro de mission -->
                                    <div class="col-sm-12">
                                        <label for="Numéro-de-mission">Numéro de mission :</label>
                                        <p>{{ $mission->numero_mission }}</p>
                                    </div>
                                    <!-- Nature -->
                                    <div class="col-sm-12">
                                        <label for="Nature">Nature :</label>
                                        <p>{{ $mission->nature }}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="Nature">Type de mission :</label>
                                        <p>{{ $mission->type_de_mission }}</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="Nature">Numéro ordre de mission:</label>
                                        <p>{{ $mission->numero_ordre_mission }}</p>
                                    </div>
                                </fieldset>

                            </div>
                            <div class="col-sm-12 col-lg d-flex">
                                <fieldset class="border col-lg-12 mb-5 p-3">
                                    <legend>Planification de mission</legend>
                                    <!-- Lieu -->
                                    <div class="col-sm-12">
                                        <label for="Lieu">Lieu :</label>
                                        <p>{{ $mission->lieu }}</p>
                                    </div>
                                    <!-- Date d'ordre de mission -->
                                    <div class="col-sm-12">
                                        <label for="Date-dordre-de-mission">Date d'ordre de mission :</label>
                                        <p>{{ $mission->data_ordre_mission }}</p>
                                    </div>
                                    <!-- Date début -->
                                    <div class="col-sm-12">
                                        <label for="Date début">Date début :</label>
                                        <p>{{ $mission->date_debut }}</p>
                                    </div>
                                    <!-- Date de fin -->
                                    <div class="col-sm-12">
                                        <label for="Date-de-fin">Date de fin :</label>
                                        <p>{{ $mission->date_fin }}</p>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <!-- Date de départ -->
                                                <label for="Date-de-départ">Date de départ :</label>
                                                <p>{{ $mission->date_depart }}</p>
                                            </div>
                                            <div>
                                                <!-- Heure de départ -->
                                                <div class="col-sm-12">
                                                    <label for="Heure-de-depart">Heure de départ :</label>
                                                    <p>{{ $mission->heure_de_depart }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <!-- Date-de-retour -->
                                                <label for="Date-de-retour">Date de retour :</label>
                                                <p>{{ $mission->date_return }}</p>
                                            </div>
                                            <div>
                                                <!-- Heure de retour -->
                                                <label for="Heure-de-retour">Heure de retour :</label>
                                                <p>{{ $mission->heure_de_return }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card-body col-sm-12 col-lg d-flex">
                            <fieldset class="border col-lg-12 mb-5 p-3">
                                <legend>Moyens des transports</legend>
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Matricule</th>
                                                <th>Personnel</th>
                                                <th>Moyens de transport</th>
                                                <th>Marque</th>
                                                <th>Numéro de plaque</th>
                                                <th>Puissance fiscale</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < max($mission->users->count(), $transports->count()); $i++)
                                                <tr>
                                                    {{-- User data --}}
                                                    @if ($i < $mission->users->count())
                                                        <td>{{ $mission->users[$i]->matricule }}</td>
                                                        <td>{{ $mission->users[$i]->nom }}</td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif

                                                    {{-- Transport data --}}
                                                    @if ($i < $transports->count())
                                                        <td>{{ $transports[$i]->transport_utiliser }}</td>
                                                        <td>{{ $transports[$i]->marque }}</td>
                                                        <td>{{ $transports[$i]->numiro_plaque }}</td>
                                                        <td>{{ $transports[$i]->puissance_fiscal }}</td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    @endif
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
