@extends('layouts.app')
@section('content')
    <div class="content-header">
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('app.edit') }}
                                {{ $dataToEdit->nom }}</h3>
                        </div>
                        <!-- Obtenir le formulaire -->
                        @include('pkg_PriseDeServices.Personnel.fields')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
