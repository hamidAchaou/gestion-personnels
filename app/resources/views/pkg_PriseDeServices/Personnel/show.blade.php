@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('pkg_PriseDeServices/User/message.detail') }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('personnels.edit', $fetchedData->id) }}"
                        class="btn btn-default float-right">{{ __('pkg_PriseDeServices/User/message.edit') }}</a>
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

                            <div class="col-sm-12">
                                <label for="nom">{{ __('pkg_PriseDeServices/User/message.name') }}:</label>
                                <p>{{ $fetchedData->nom }}</p>
                            </div>

                            <!-- Description Field -->
                            <div class="col-sm-12">
                                <label for="description">{{ __('pkg_PriseDeServices/User/message.description') }}:</label>
                                @if ($fetchedData->description)
                                    <p>
                                        {!! $fetchedData->description !!}
                                    </p>
                                @else
                                    <p class="text-secondary">Aucune information disponible</p>
                                @endif

                            </div>

                            <!-- Description Field -->
                            <div class="col-sm-12">
                                <label for="description">{{ __('pkg_PriseDeServices/User/message.date') }}:</label>
                                <p>{{ __('pkg_PriseDeServices/personnel/message.startDate') }}: {{ $fetchedData->date_debut }}</p>
                                <p>{{ __('pkg_PriseDeServices/personnel/message.endDate') }}: {{ $fetchedData->date_de_fin }}</p>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
