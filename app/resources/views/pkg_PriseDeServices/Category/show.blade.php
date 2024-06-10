@extends('layouts.app')
@section('content')
    <div style="min-height: 1604.71px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Plus d'une formation</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="javascript:history.go(-1);" class="btn btn-default float-right">
                            <i class="fa-solid fa-arrow-left"></i> Retour
                        </a>
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
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('images/man.png') }}" alt="Photo de profil">
                                    </div>
                                    <h3 class="profile-username text-center"></h3>
                                    <p class="text-muted text-center">{{$personnelData->fonction->nom}}</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Matricule</b>
                                            <h6 class="float-right text-purple">{{$personnelData->matricule}}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Établissement</b>
                                            <h6 class="float-right text-purple">{{$personnelData->etablissement->nom}}</h6>
                                        </li>
                                    </ul>
                                    <div class="row pt-1 justify-content-between">
                                        <a href="{{-- route('conge.show') --}}" class="btn btn-default btn-block col-md-3 mt-2">
                                            <i class="fa-solid fa-bars-staggered mr-2"></i>
                                        </a>
                                        <a href="{{-- route('absences.show') --}}" class="btn btn-default btn-block col-md-3 mt-2">
                                            <i class="fa-regular fa-calendar-minus mr-2"></i>
                                        </a>
                                        <a href="{{-- route('missions.show') --}}" class="btn btn-default btn-block col-md-3 mt-2">
                                            <i class="fa-solid fa-business-time mr-2"></i>
                                        </a>
                                    </div>
                                </div>

                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card card-purple card-outline">

                            <div class="card-body">
                                <div class="tab-content">
                                    <table class="table table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Echell</th>
                                                <th>Périod</th>
                                                <th>Grade</th>
                                                <th class="text-center">{{ __('app.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fetchedData as $data)
                                                <tr>
                                                    <td>{{ $data->echell }}</td>
                                                    <td>{{ $data->date_debut }} / {{ $data->date_fin }}</td>
                                                    <td>{{ $data->grade_name }}</td>

                                                    <td class="text-center">
                                                        <form action="{{ route('categories.destroy', $data->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce personnel ?')">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
