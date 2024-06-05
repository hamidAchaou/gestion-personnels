<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap table-print">
        <thead>
            <tr>
                <th>Annee juridique</th>
                <th>Nom</th>
                <th>Formateur</th>
                <th>Administrateur</th>
                <th class="text-center">Date debut</th>
                <th class="text-center">Date fin</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jourFeries as $jourFerie)
                <tr>
                    <td>{{ $jourFerie->anneeJuridique->annee }}</td>
                    <td>{{ $jourFerie->nom }}</td>
                    <td>{{ $jourFerie->is_formateur ? 'True' : 'False' }}</td>
                    <td>{{ $jourFerie->is_administrateur ? 'True' : 'False' }}</td>
                    <td class="text-center">{{ $jourFerie->date_debut }}</td>
                    <td class="text-center">{{ $jourFerie->date_fin }}</td>
                    <td class="text-center">
                        <a href="" class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucune jour Ferie ñ'a</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="row justify-content-between p-2">
    <div class="col-6 align-self-end d-flex">
        <form action="" method="post" enctype="multipart/form-data" id="importForm">
            @csrf
            <label for="upload" class="btn btn-default btn-sm mb-0 font-weight-normal">
                <i class="fa-solid fa-file-arrow-down"></i>
                {{ __('app.import') }}
            </label>
            <input type="file" id="upload" name="file" style="display:none;" onchange="submitForm()" />
        </form>

        <a href="" class="btn  btn-default btn-sm mt-0 mx-2">
            <i class="fa-solid fa-file-export"></i>
            {{ __('app.export') }}</a>
    </div>
    <div class="col-6">
        <ul class="pagination  m-0 float-right">
            {{ $jourFeries->onEachSide(1)->links() }}
        </ul>
    </div>
</div>
