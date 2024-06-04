@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="nav-icon fas fa-table"></i>
                                Ajouter une mission
                            </h3>
                        </div>
                        <!-- Obtenir le formulaire -->
                        @include('pkg_OrderDesMissions.fields')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
