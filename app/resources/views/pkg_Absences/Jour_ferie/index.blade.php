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
                        List des Jour férié
                    </h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="" class="btn btn-info">
                            <i class="fas fa-plus"></i> Ajouter une absence
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
                    <div class="card">
                        <div class="card-header col-md-12">
                            <div class="row justify-content-end">
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
                        {{-- include table --}}
                        @include('pkg_Absences.Jour_ferie.table')
                    </div>

                </div>
            </div>
        </div>

    </section>


@endsection
