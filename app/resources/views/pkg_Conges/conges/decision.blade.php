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
                <h2 class="mb-0">Decision de {{ optional($conge->personnel)->nom }} {{ optional($conge->personnel)->prenom }}</h2>
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
            <p>Tanger le {{ $currentDate }}</p>
        </div>
    </div>

    <div class="decision-body">
        <div class="border py-3 my-4 text-center">
            <h2 class="">DECISION DE CONGE ADMINISTRATIF</h2>
        </div>
        <div class="mt-2">
            <ul class="list-group list-group-flush" style="letter-spacing: 1px; line-height: 2; font-weight: 500;">
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> le Directeur de l'Office
                    de la Formation Professionnelle et de La Promotion du Travail;</li>
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> Vu Le Dahir portant loi
                    N°1-72-183 RabiaII 1394 (21 Mai 1974) instituant l'Office de la Formation Professionnelle et de La
                    Promotion du Travail;</li>
                <li class="list-group-item border-0"><i class="fas fa-check-circle me-2"></i> Vu la décision de madame
                    le Directeur Général N°11 en Date du 19/01/2022 portant Délégation de signature a Monsieur
                    ABDELHAMID ELMECHRAFI Directeur de Complex Tanger 1;</li>
            </ul>
            <p class="pt-3" style="letter-spacing: 1px; line-height: 2; font-weight: 500;">Vu la demande de congé
                Administratif présentée par : Mme/Mr: Nom Prenom, affecté a CFP Tanger\Centre\ Solicode Tanger.</p>
        </div>

        <h4 class="text-center pt-5 pb-4">DECIDE</h4>
        <div>
            <h4 style="text-decoration: underline;">ARTICLE UNIQUE :</h4>
            <p class="mt-3">Il est accordé un congé : Administratif</p>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>NOM & PRENOM</th>
                        <th>AFFECTATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ optional($conge->personnel)->nom }} {{ optional($conge->personnel)->prenom }}</td>
                        <td>CFP TANGER 1 / CENTRE <span class="text-uppercase">{{ $etablissement }}</span> TANGER</td>
                    </tr>
                    <tr>
                        <td>Catégorie : C</td>
                        <td>Durée accordée : {{ $conge->nombre_jours }}</td>
                    </tr>
                    <tr>
                        <td>Fonction: 
                            @forelse ($conge->personnels as $personnel)
                                {{ $personnel->fonction->nom }}
                            @empty
                            @endforelse
                        </td>
                        <td>Date debut : {{ $conge->date_debut }}</td>
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
            <h5>NB : L'intéressée est autorisée à quitter le territoire marocain</h5>
        </div>
    </div>
    <!-- footer -->
    <div class="decision-footer   border-top pt-3 mt-5">
        <div class="text-center">
            <h5 class="font-weight-bold pl-5 ml-5">Complex de Formation Professionnelle Tanger 1</h5>
        </div>
        <div class="d-flex justify-content-between w-100">
            <p class="font-weight-bold text-center">Direction <br> Régionale <br> DRTTA <br> CFP Tanger</p>
            <p class="">ISTA NTIC <br> Km 06, Route de Rabat <br> Tanger <br> Tel : 06 39 38 08 71</p>
            <p class="">ISTA IBN MARHAL <br> 5 Rue Ibn Marhal, Place <br> Mozart Tanger <br> Tel : 0539 380871</p>
            <p class="">Centre solicode Digitale <br> Quartier Bni Ouryaghel <br> Tanger</p>
            <p class="">Centre National Mohamed <br> VI des handicapés Tanger <br> Souani Tanger</p>
        </div>
    </div>
</section>
@endsection
