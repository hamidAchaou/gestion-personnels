<table class="table table-striped text-nowrap">
    <thead>
        <tr>
            <th>Matricule</th>
            <th>Personnel</th>
            <th class="text-center">Date début</th>
            <th class="text-center">Date fin</th>
            <th class="text-center">Motif</th>
            <th class="text-center">Décision</th>
            <th class="text-center">État</th>
        </tr>
    </thead>
    <tbody id="conjeTable">
        @forelse ($conges as $conge)
            @foreach ($conge->personnels as $personnel)
                @if ($personnel->hasRole('admin'))
                    @continue
                @endif
                <tr>
                    <td>{{ $personnel->matricule }}</td>
                    <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>
                    <td class="text-center">{{ $conge->date_debut }}</td>
                    <td class="text-center">{{ $conge->date_fin }}</td>
                    <td class="text-center">{{ $conge->motif->nom }}</td>
                    <td class="text-center">
                        <a href="{{ route('conges.decision', ['conge' => $conge->id]) }}"
                            class='btn btn-default btn-sm'>
                            <i class="fa-regular fa-file"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('conges.show', ['conge' => $personnel->id]) }}"
                            class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="7" class="text-center">Aucun congé trouvé.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <div class="card-footer" id="card-footer">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div class="">
                            <div class="d-flex align-items-center">
                                <form action="{{ route('conges.import') }}" method="post" class="mt-2"
                                    enctype="multipart/form-data" id="importForm">
                                    @csrf
                                    <label for="upload" class="btn btn-default btn-sm">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                        IMPORTER
                                    </label>
                                    <input type="file" id="upload" name="file" style="display:none;"
                                        onchange="submitForm()" />
                                </form>

                                <button type="button" class="btn btn-default btn-sm mt-0 mx-2 font-weight-bold"
                                    data-bs-toggle="modal" data-bs-target="#filterModal">
                                    <i class="fas fa-file-export"></i>
                                    EXPORTER
                                </button>
                            </div>
                        </div>
                        <div>
                            <ul class="pagination m-0 float-right">
                                {{ $conges->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
