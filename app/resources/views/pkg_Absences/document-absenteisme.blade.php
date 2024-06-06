@extends('layouts.app')
@section('title', __('pkg_Absences/Absence.singular'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Document d'absentéisme</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('absence.index') }}" class="btn btn-default"> <i class="fa-solid fa-arrow-flesh"></i>
                            retoure</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('absence.filterAndPrint') }}" method="GET" target="_blank"
                                id="printForm">
                                <div class="form-group">
                                    <label for="date_debut">Date de début</label>
                                    <input name="date_debut" type="date" class="form-control" id="date_debut"
                                        placeholder="Date de début" required>
                                </div>
                                <div class="form-group">
                                    <label for="date_fin">Date de fin</label>
                                    <input name="date_fin" type="date" class="form-control" id="date_fin"
                                        placeholder="Date de fin" required>
                                </div>
                                <div class="form-group">
                                    <label>Motif</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                        <label class="form-check-label" for="select-all">Tout sélectionner</label>
                                    </div>
                                    <br>
                                    @foreach ($motifs as $index => $motif)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input motif-checkbox" type="checkbox" name="motifs[]"
                                                id="motif{{ $index }}" value="{{ $motif->id }}">
                                            <label class="form-check-label"
                                                for="motif{{ $index }}">{{ $motif->nom }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('absence.index') }}" class="btn btn-default mr-3">Annuler</a>
                                    <button type="submit"  class="btn bg-purple"><i
                                            class="fa-solid fa-print"></i> Imprimer</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
