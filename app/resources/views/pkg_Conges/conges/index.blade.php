@extends('layouts.app')
@section('title', 'List des Conges')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des congés</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('conges.create') }}" class="btn btn-info">
                            <i class="fas fa-plus"></i> Nouveau congé
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-md-4 d-flex">
                                    <input type="hidden" value="{{$etablissement}}" id="inpEtablissement">
                                    <div class="input-group input-group-sm mr-2">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        </div>
                                        <input type="date" class="form-control" id="startDate" aria-label="Start Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text">au</span>
                                        </div>
                                        <input type="date" class="form-control" id="endDate" aria-label="End Date">
                                        <div class="input-group-append">
                                            <button type="submit" id="filter_button" class="btn btn-default">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="col-md-3 p-0 d-flex">
                                    <div class="input-group input-group-sm ml-auto">
                                        <input type="hidden" name="page" id="page" value="1">
                                        <input type="text" name="table_search" id="table_search" class="form-control" placeholder="Recherche">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="card-body table-responsive p-0">
                            @include('pkg_Conges.conges.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Export par Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('conges.export') }}" method="GET">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de Début :</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut">
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de Fin :</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin">
                            </div>
                            <button type="submit" class="btn btn-secondary d-flex justify-content-end" data-bs-dismiss="modal" aria-label="Close">Exporter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

