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

<div class="row justify-content-between p-2">
    <div class="col-6 align-self-end">
        <button type="button" class="btn btn-default btn-sm">
            <i class="fa-solid fa-file-arrow-down"></i>
            IMPORTER</button>
        <button type="button" data-toggle="modal" data-target="#exampleModalCenter"
            class="btn  btn-default btn-sm mt-0 mx-2">
            <i class="fa-solid fa-file-export"></i>
            EXPORTER</button>
    </div>
    <div class="col-6">
        <ul class="pagination  m-0 float-right">
            {{ $missions->links() }}
        </ul>
    </div>
</div>
