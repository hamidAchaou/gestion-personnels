<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>{{ __('app.matricule') }}</th>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.lastName') }}</th>
                <th>{{ __('app.phoneNumber') }}</th>
                <th>{{ __('app.role') }}</th>
                <th>{{ __('app.school') }}</th>
                <th>{{ __('app.certificate') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personnelsData as $employee)
                @if (Auth::user()->hasRole('admin') && Auth::user()->id == $employee->id)
                    @continue
                @endif
                @if (Auth::user()->hasRole('responsable') && Auth::user()->id == $employee->id || $employee->id == $userId)
                    @continue
                @endif

                <tr>
                    <td>{{ $employee->matricule }}</td>
                    <td>{{ $employee->nom }}</td>
                    <td>{{ $employee->prenom }}</td>
                    <td>{{ $employee->telephone }}</td>
                    @if ($employee->fonction !== null)
                        <td>{{ $employee->fonction->nom }}</td>
                        <td>{{ $employee->etablissement->nom }}</td>
                    @endif

                    <td class="text-center">
                        <a href="{{ route('personnels.attestation', $employee) }}" class='btn btn-default btn-sm'>
                            <i class="fa-regular fa-file"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        @can('show-PersonnelController')
                            <a href="{{ route('personnels.show', $employee) }}" class="btn btn-default btn-sm">
                                <i class="far fa-eye"></i>
                            </a>
                        @endcan
                        <a href="{{ route('personnels.edit', $employee) }}" class="btn btn-sm btn-default">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('personnels.destroy', $employee) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce personnel ?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center p-2">
    <div class="d-flex align-items-center mb-2 ml-2 mt-2">
        @can('import-PersonnelController')
            <form action="{{ route('personnels.import') }}" method="post" class="mt-2" enctype="multipart/form-data"
                id="importForm">
                @csrf
                <label for="upload" class="btn btn-default btn-sm font-weight-normal">
                    <i class="fas fa-file-download"></i>
                    {{ __('app.import') }}
                </label>
                <input type="file" id="upload" name="file" style="display:none;" />
            </form>
        @endcan
        @can('export-PersonnelController')
            <form class="">
                <a href="{{ route('personnels.export') }}" class="btn btn-default btn-sm mt-0 mx-2">
                    <i class="fas fa-file-export"></i>
                    {{ __('app.export') }}</a>
            </form>
        @endcan
    </div>
    <div class="">
        <ul class="pagination  m-0 float-right">
            {{ $personnelsData->links() }}
        </ul>
    </div>
</div>
