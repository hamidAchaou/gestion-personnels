@extends('layouts.app')
@section('title', __('pkg_Absences/Absence.singular'))

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pt-4">

                    <div class="card card-teal">
                        <div class="card-header">
                            <h3 class="card-title"> <i class="fa-regular fa-calendar-minus mr-2"></i>
                                {{ __('app.edit') }}
                                {{-- __('app.edit') . ' ' . __('pkg_Absences/absence.singular') --}}
                            </h3>
                        </div>
                        <!-- Inclusion du formulaire -->
                        @include('pkg_Absences.form')
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
