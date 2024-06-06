<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>N<sup>o</sup> mission</th>
                <th>Type de mission</th>
                <th>Lieu</th>
                <th class="">Durée</th>
                <th class="">Date de départ</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($missions as $item)
                <tr>
                    <td>{{ $item->numero_mission }}</td>
                    <td>{{ $item->type_de_mission }}</td>
                    <td>{{ $item->lieu }}</td>
                    <td>{{ $item->duration }}</td>
                    <td>{{ $item->date_depart }}</td>
                    <td class="text-center">
                        <a href="{{ route('missions.moreDetails', $item) }}" class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('missions.edit', $item->id) }}"
                            class="btn btn-sm btn-default">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
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
        <button type="button" class="btn btn-default btn-sm ">
            <i class="fa-solid fa-file-export"></i>
            EXPORTER</button>
    </div>
    <div class="col-6">
        <ul class="pagination m-0 float-right">
            {{ $missions->links() }}
        </ul>
    </div>
</div>
