<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.echell') }}</th>
                <th>{{ __('app.dateDebut') }}</th>
                <th>{{ __('app.dateFin') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categoriesData as $category)
                <tr>
                    <td>{{ $category->personnel_name }}</td>
                    <td>{{ $category->echell }}</td>
                    <td>{{ $category->date_debut }}</td>
                    <td>{{ $category->date_fin }}</td>

                    <td class="text-center">
                        @can('show-AvancementController')
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-default btn-sm">
                                <i class="far fa-eye"></i>
                            </a>
                        @endcan
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-default">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce categorie ?')">
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
        @can('import-AvancementController')
            <form action="{{ route('categories.import') }}" method="post" class="mt-2" enctype="multipart/form-data"
                id="importForm">
                @csrf
                <label for="upload" class="btn btn-default btn-sm font-weight-normal">
                    <i class="fas fa-file-download"></i>
                    {{ __('app.import') }}
                </label>
                <input type="file" id="upload" name="file" style="display:none;" />
            </form>
        @endcan
        @can('export-AvancementController')
            <form class="">
                <a href="{{ route('categories.export') }}" class="btn btn-default btn-sm mt-0 mx-2">
                    <i class="fas fa-file-export"></i>
                    {{ __('app.export') }}</a>
            </form>
        @endcan

    </div>
    <div class="">
        <ul class="pagination  m-0 float-right">
            {{ $categoriesData->links() }}
        </ul>
    </div>
</div>
