@extends('layouts.app')

@section('title', 'Décision des Conges')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="btn btn-default mr-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="mb-0">Décision de {{ optional($conge->personnel)->nom }} {{ optional($conge->personnel)->prenom }}</h2>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <button id="printButton" class="btn bg-purple">
                        <i class="fa-solid fa-print"></i> Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content px-4 mx-4 card">
    <div class="decesion-head-top">
        <div class="d-flex justify-content-center py-5">
            <img src="{{ asset("images/logo-ofppt.png")}}" alt="" height="auto" width="60%">
        </div>
        <div class="d-flex justify-content-between mt-3">
            <p>REF: OFP/DRTTA/CFP1/<span class="text-uppercase">{{ $etablissement }}</span>/N 38/22</p>
            <p>Tanger, le {{ $currentDate }}</p>
        </div>
    </div>

    <div class="decision-body">
        <div class="border py-3 my-4 text-center">
            <h2 class="">DÉCISION DE CONGÉ ADMINISTRATIF</h2>
        </div>
        <div class="mt-2">
            <ul class="list-group list-group-flush" style="letter-spacing: 1px; line-height: 2; font-weight: 500;">
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> Le Directeur de l'Office
                    de la Formation Professionnelle et de la Promotion du Travail ;</li>
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> Vu le Dahir portant loi
                    N°1-72-183 RabiaII 1394 (21 mai 1974) instituant l'Office de la Formation Professionnelle et de la
                    Promotion du Travail ;</li>
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> Vu la décision de Madame
                    la Directrice Générale N°11 en date du 19/01/2022 portant délégation de signature à Monsieur
                    ABDELHAMID ELMECHRAFI, Directeur du Complexe Tanger 1 ;</li>
            </ul>
            <p class="pt-3" style="letter-spacing: 1px; line-height: 2; font-weight: 500;">Vu la demande de congé
                administratif présentée par : Mme/Mr : Nom Prénom, affecté(e) à CFP Tanger\Centre\ Solicode Tanger.</p>
        </div>

        <h4 class="text-center pt-5 pb-4">DÉCIDE</h4>
        <div>
            <h4 style="text-decoration: underline;">ARTICLE UNIQUE :</h4>
            <p class="mt-3">Il est accordé un congé : Administratif</p>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>NOM & PRÉNOM</th>
                        <th>AFFECTATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $conge->personnel->nom }} {{ $conge->personnel->prenom }}</td>
                        <td>CFP TANGER 1 / CENTRE <span class="text-uppercase">{{ $etablissement }}</span> TANGER</td>
                    </tr>
                    <tr>
                        <td>Catégorie : {{ $grade }}</td>
                        <td>Durée accordée : {{ $conge->nombre_jours }}</td>
                    </tr>
                    <tr>
                        <td>Fonction:
                            @if ($conge->personnel && $conge->personnel->fonction)
                                {{ $conge->personnel->fonction->nom }}
                            @else
                                Fonction non trouvée
                            @endif
                        </td>
                        
                        <td>Date début : {{ $conge->date_debut }}</td>
                    </tr>
                    <tr>
                        <td>Matricule : 
                            @forelse ($conge->personnels as $personnel)
                                {{ $personnel->matricule }}
                            @empty
                            @endforelse
                        </td>
                        <td>Date fin : {{ $conge->date_fin }}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        <div class="NB py-5 px-4">
            <h5>NB : L'intéressé(e) est autorisé(e) à quitter le territoire marocain</h5>
        </div>
    </div>
    <!-- pied de page -->
    <div class="decision-footer border-top pt-3 mt-5">
        <div class="text-center">
            <h5 class="font-weight-bold pl-5 ml-5">Complexe de Formation Professionnelle Tanger 1</h5>
        </div>
        <div class="d-flex justify-content-between w-100">
            <p class="font-weight-bold text-center">Direction <br> Régionale <br> DRTTA <br> CFP Tanger</p>
            <p class="">ISTA NTIC <br> Km 06, Route de Rabat <br> Tanger <br> Tél : 06 39 38 08 71</p>
            <p class="">ISTA IBN MARHAL <br> 5 Rue Ibn Marhal, Place <br> Mozart Tanger <br> Tél : 0539 380871</p>
            <p class="">Centre Solicode Digital <br> Quartier Bni Ouryaghel <br> Tanger</p>
            <p class="">Centre National Mohamed <br> VI des handicapés Tanger <br> Souani Tanger</p>
        </div>
    </div>
</section>
<style>
    .decision-body p,
    .NB {
        letter-spacing: 1px;
        line-height: 2;
        font-weight: 500;
    }

    .decision-footer p {
        font-size: 16px;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .content,
        .content * {
            visibility: visible;
        }

        .content {
            position: absolute;
            left: 0;
            top: 0;
        }

        .content {
            width: 100%;
        }

        .decesion-head-top {
            text-align: center;
        }

        .decesion-head-top img {
            max-height: 100px;
            width: auto;
        }

        .decision-body {
            margin-top: 30px;
        }

        .decision-body h2 {
            font-size: 24px;
            text-align: center;
        }

        .decision-body ul {
            list-style-type: none;
            padding-left: 0;
        }

        .decision-body h5 {
            font-size: 16px;
            margin-top: 15px;
        }

        .decision-body .table th,
        .decision-body .table td {
            font-size: 14px;
            padding: 5px 10px;
        }

        .decision-footer {
            width: 100%;
            margin-top: 30px;
            padding-top: 10px;
        }

        .decision-footer h5 {
            font-size: 14px;
            text-align: center;
            margin-left: 10px;
        }

        .decision-footer h6 {
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    }
</style>
@endsection
