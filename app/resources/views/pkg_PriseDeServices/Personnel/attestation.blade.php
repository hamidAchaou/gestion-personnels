@extends('layouts.app')

@section('content')
    <div class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attestaion de travail</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button id="printButton" class="btn bg-purple"><i class="fa-solid fa-print"></i>
                                Imprimer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            @media print {
                .main-footer, .content-header .container-fluid .row.mb-2, .alert.alert-success {
                    display: none !important;
                }
                .card {
                    page-break-inside: avoid;
                }
            }
        </style>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-4">
                            <img src="{{ asset('images/logo-ofppt.png') }}" alt="" height="130px" width="auto">
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <p>N/REF: OFP/DRTTA/CFPT1/SOLICODE/N°25/2023</p>
                            <p>Tanger le 30/11/2022</p>
                        </div>
                        <div class="border py-3 my-4 text-center">
                            <h2 class="">Attestation de travail</h2>
                        </div>
                        <div class="mt-2">
                            <p>L'office de la Formation Professionnelle et de la Promotion du Travail attest que</p>
                        </div>
                        <div class="col-sm-12">
                            <div class="d-flex">
                                <div>
                                    <p>Monsieur</p>
                                    <p>Matricule</p>
                                    <p>Est employé(e) au sein de nos services</p>
                                    <p>En qualité de</p>
                                    <p>Grade</p>
                                    <p>Date de recrutement</p>
                                    <p>Affectation</p>
                                </div>
                                <div>
                                    <p class="ml-5">: {{ $personnelsData->nom . ' ' . $personnelsData->prenom }}</p>
                                    <p class="ml-5">: {{ $personnelsData->matricule }}</p>
                                    <p>.</p>
                                    <p class="ml-5">: {{ $personnelsData->fonction->nom }}</p>
                                    <p class="ml-5">: {{ $personnelsData->grade->nom }}</p>
                                    <p class="ml-5">: {{$personnelsData->created_at->format('Y/m/d')}}</p>
                                    <p class="ml-5">: CFPT1 Tanger / {{$personnelsData->etablissement->nom}}</p>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <p>La présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end mt-4 mb-2">
                                <div>
                                    <h4>Directeur de complexe</h4>
                                </div>
                            </div>
                        </div>
                        <div class="py-5 px-4"></div>
                        <!-- footer -->
                        <section class="col-12 mt-3 footer">
                            <div class="mt-3" style="border-top: 2px solid black;">
                                <p class="display-5 font-weight-bold text-capitalize text-center">
                                    Complexe de formation professionnelle Tanger 1
                                </p>
                                <div class="row">
                                    <div class="col font-weight-bold">
                                        Directeur Regionale DRTTA <br> CFP Tanger 1
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="text-uppercase">ISTA NTIC</li>
                                            <li class="text-capitalize">Km 06, Route de Rabat- Tanger</li>
                                            <li>Téléphone : 05 39 38 08 71</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="text-uppercase">ISTA IBN MARHAL</li>
                                            <li class="text-capitalize">5 Rue Ibn Marhal, Place Mozart Tanger</li>
                                            <li>Téléphone : 05 39 94 00 97</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="text-uppercase">Solicode Tanger</li>
                                            <li class="text-capitalize">Quartier Bni Ouaryaghel Allé C Tanger</li>
                                            <li>Téléphone : 05 39 30 88 85</li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="text-capitalize">Centre National Mohamed 6 des handicapés Tanger Souani Tanger</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("printButton").addEventListener("click", function() {
            window.print();
        });
    });
</script>
@endsection
