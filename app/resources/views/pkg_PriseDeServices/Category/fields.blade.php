<form action="{{ $dataToEdit ? route('categories.update', $dataToEdit->id) : route('categories.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if ($dataToEdit)
        @method('PUT')
    @endif
    <div class="card-body ">
        <div class="row">
            <div class="form-group pt-3 col-lg-12" data-select2-id="29">
                <label>Personnel : <span class="text-danger">*</span></label>
                <select name="personnel_id" class="form-control js-example-basic-single select2" id="personnel_id"
                    required>
                    <option value="">Sélectionner un personnel</option>
                    @foreach ($personnels as $personnel)
                        <option value="{{ $personnel->id }}"
                            {{ $dataToEdit && $dataToEdit->personnel->id == $personnel->id ? 'selected' : '' }}>
                            {{ $personnel->nom }}
                        </option>
                    @endforeach
                </select>
                @error('fonction_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group pt-3 col-lg-12" data-select2-id="29">
                <label>Echell : <span class="text-danger">*</span></label>
                <select name="echell" class="form-control js-example-basic-single" id="echell" required>
                    <option value="">Sélectionner une ville</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                </select>
                @error('fonction_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group pt-3 col-lg-12">
                <label for="inputStartDate">Date de début : <span class="text-danger">*</span></label>
                <input name="date_debut" type="date" class="form-control" id="inputStartDate"
                    placeholder="Sélectionnez la date de début" value="2023-01-01" required="">
                @error('date_debut')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group pt-3 col-lg-12" data-select2-id="29">
                <label>Grade : <span class="text-danger">*</span></label>
                <input type="text" name="grade_id" class="form-control" id="grade_id" readonly required placeholder="Le grade sera sélectionné automatiquement.">
                <input type="hidden" name="grade" id="grade">
                @error('fonction_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="card-footer w-100 d-flex justify-content-end mt-3">
                <a href="{{ route('categories.index') }}" class="btn btn-default mr-2">Annuler</a>
                <button type="submit" class="btn {{ $dataToEdit ? 'bg-teal' : 'btn-info' }}">
                    {{ $dataToEdit ? 'Modifier' : 'Ajouter' }}
                </button>
            </div>

        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#echell').on('change', function() {
            var urlPath =  window.location.href;
            console.log(urlPath);
            var selectedEchell = $(this).val();
            if (selectedEchell) {
                $.ajax({
                    url: urlPath, 
                    type: 'GET',
                    data: {
                        echell: selectedEchell
                    },
                    success: function(response) {
                        var gradeInput = $('#grade_id');
                        var gradeId = $('#grade');
                        gradeInput.empty();
                        $.each(response, function(key, grade) {
                            gradeInput.val(grade.nom);
                            gradeId.val(grade.id);
                        console.log(grade.nom);
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            } else {
                $('#grade').empty();
                $('#grade').append('<option value="">Sélectionner un grade</option>');
            }
        });
    });
</script>
