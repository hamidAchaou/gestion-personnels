@extends('layouts.app')
@section('title', __('pkg_Absences/Absence.singular'))

@section('content')

    <div class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('error') }}.
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @php
                            use App\helpers\TranslationHelper;
                            $lang = Config::get('app.locale');
                            $translatedName = TranslationHelper::getTitle(__('pkg_Absences/absence.plural'), $lang);
                            echo $translatedName;
                        @endphp
                    </h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        @can('create-AbsenceController')
                            <a href="{{ route('absence.create') }}" class="btn btn-info">
                                <i class="fas fa-plus"></i> Ajouter une absence
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header col-md-12">
                            <div class="row justify-content-between">
                                <div class="row">
                                    <!-- filter by motif -->
                                    <div class="input-group-sm input-group col-md-4">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-filter "></i>
                                            </button>
                                        </div>
                                        <select class="form-select form-control" id="filterSelectMotif"
                                            aria-label="Filter Select" name="motif">
                                            <option value="" selected disabled>--Motif--</option>
                                            @foreach ($motifs as $motif)
                                                <option value="{{ $motif->nom }}">
                                                    {{ $motif->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- filter by start date / end date -->
                                    <div class="col-md-8 row">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                            <label for="date_debut" class="sr-only">Date debut</label>
                                            <input type="date" class="form-control" id="date_debut"
                                                aria-label="Start Date">
                                            <label for="date_fin" class="sr-only">Date fin</label>
                                            <input type="date" class="form-control" id="date_fin" aria-label="End Date">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">

                                        <div class="p-0">
                                            <div class="input-group-sm input-group">
                                                <input id="table_search" type="text" name="table_search"
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
                        @include('pkg_Absences.table')
                    </div>

                </div>
            </div>
        </div>

    </section>


@endsection
