<div class="tab-pane fade" id="detailsJourReson" role="tabpanel" aria-labelledby="custom-tabs-one-moreDetails-tab">
    <!-- Année 1 -->
    <div class="card collapsed-card">
        <div class="card-header border-0">
            <h3 class="card-title">
                <i class="fa-solid fa-calendar-days"></i> {{ $lastYear }} (jours restant = {{ $CongesLastYear->sum('jours_restants') }})
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-teal btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: none;">
            <table class="table table-striped text-nowrap">
                <thead>
                    <tr>
                        <th>Date départ</th>
                        <th>Date retour</th>
                        <th class="text-center">Nombre de jours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($CongesLastYear as $conge)
                        <tr>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td class="text-center">{{ $conge->nombre_jours }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td class="text-center">{{ $CongesLastYear->sum('nombre_jours') }}</td>
                    </tr>
                    <tr>
                        <td>Jours restants</td>
                        <td></td>
                        <td class="text-center">{{ $CongesLastYear->sum('jours_restants') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Année 2 -->
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title">
                <i class="fa-solid fa-calendar-days"></i> {{ $firstYear }} (jours restant = {{ $CongesFirstYear->sum('jours_restants') }})
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-teal btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            <table class="table table-striped text-nowrap">
                <thead>
                    <tr>
                        <th>Date départ</th>
                        <th>Date retour</th>
                        <th class="text-center">Nombre de jours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($CongesFirstYear as $conge)
                        <tr>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td class="text-center">{{ $conge->nombre_jours }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td class="text-center">{{ $CongesFirstYear->sum('nombre_jours') }}</td>
                    </tr>
                    <tr>
                        <td>Jours restants</td>
                        <td></td>
                        <td class="text-center">{{ $CongesFirstYear->sum('jours_restants') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
