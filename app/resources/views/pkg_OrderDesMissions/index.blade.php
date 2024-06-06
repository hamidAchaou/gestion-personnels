@extends('layouts.app')

@section('content')
    <div class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des ordre des missions</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('missions.create') }}" class="btn btn-info">
                            <i class="fas fa-plus"></i>
                            {{ __('app.add') }} missions
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header col-md-12">
                        <div class="row justify-content-between">
                            <div class="col-4">
                                <div class="">
                                    <div class=" p-0">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-filter "></i>
                                                </button>
                                            </div>
                                            <select class="form-control select-moyens-de-transport">
                                                <option value="missions-actuelles" class="missions-actuelles">Missions
                                                    actuelles
                                                </option>
                                                <option value="missions-precedentes" class="missions-precedentes">Missions
                                                    précédentes
                                                </option>
                                                <option value="prochaines-missions" class="prochaines-missions">Prochaines
                                                    missions
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">

                                    <div class=" p-0">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="table_search" class="form-control"
                                                placeholder="Recherche">
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
                    @include('pkg_OrderDesMissions/table')
                </div>
            </div>
        </div>
        <input type="hidden" id='page' value="1">
    </section>
@endsection
