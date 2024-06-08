<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Personnel</th>
                <th>Nom de mission</th>
                <th>Lieu</th>
                <th>Durée</th>
                <th>Date de départ
                </th>
                <th>Attestation</th>
                <th class="text-center">État</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($missions as $mission)
                <tr>

                    <td>
                        <ol>
                            @foreach ($mission->users as $user)
                                <li>
                                    {{ $user->matricule }}
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td>
                        <ol>
                            @foreach ($mission->users as $user)
                                <li>
                                    {{ $user->nom }}
                                </li>
                            @endforeach
                        </ol>
                    </td>

                    <td>{{ $mission->type_de_mission }}</td>
                    <td>{{ $mission->lieu }}</td>
                    <td>{{ $mission->duration }}</td>
                    <td>{{ $mission->date_depart }}</td>
                    <td class="text-center">
                        <ol>
                            @foreach ($mission->users as $user)
                                <li class="my-1">
                                    <a href="{{ route('missions.certificate', [$mission->id, $user->id]) }}"
                                        class="btn btn-default btn-sm">
                                        <i class="fa-regular fa-file"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('missions.moreDetails', $mission) }}" class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-md-flex justify-content-between align-items-center p-2">
    <div class="d-flex align-items-center mb-2 ml-2 mt-2">
        <form action="{{ route('missions.import') }}" method="post" class="mt-2" enctype="multipart/form-data"
            id="importForm">
            @csrf
            <label for="upload" class="btn btn-default btn-sm font-weight-normal">
                <i class="fas fa-file-download"></i>
                {{ __('app.import') }}
            </label>
            <input type="file" id="upload" name="file" style="display:none;" />
        </form>
        <button type="button" data-target="#modal-sm" data-toggle="modal" class="btn  btn-default btn-sm mt-0 mx-2">
            <i class="fa-solid fa-file-export"></i>
            EXPORTER</button>
    </div>
    <div>
        <ul class="pagination  m-0 float-right">
            {{ $missions->links() }}
        </ul>
    </div>
</div>


<div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('missions.export') }}">

                <div class="modal-header">
                    <h4 class="modal-title">Exporte des missions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="mission_precedente"
                            id="mission-precedente">
                        <label class="form-check-label" for="mission-precedente">Missions précédentes</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="mission_actuel" id="mission-actuel">
                        <label class="form-check-label" for="mission-actuel">Missions actuelles</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="prochaines_missions"
                            id="prochaines-missions">
                        <label class="form-check-label" for="prochaines-missions">Prochaines missions</label>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn  btn-default btn-sm mt-0 mx-2">
                        <i class="fa-solid fa-file-export"></i>
                        EXPORTER</button>
                </div>
            </form>
        </div>

    </div>

</div>
