<form action="{{ $dataToEdit ? route('missions.update', $dataToEdit->id) : route('missions.store') }}" method="POST">
    @csrf
    @if ($dataToEdit)
        @method('PUT')
    @endif
    <div class="card-body">
        <div class="row">

            <div class="form-group col-lg-6 col-12">
                <label for="Personnel">Personnel <span class="text-danger">*</span></label>
                <select class="form-control" name="users[]" multiple id="">
                    @foreach ($personnels as $personnel)
                        <option value="{{ $personnel->id }}">{{ $personnel->nom }}</option>
                    @endforeach
                </select>
                @error('users')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="numero_mission">Numéro de mission <span class="text-danger">*</span></label>
                <input name="numero_mission" type="text" class="form-control" id="numero_mission"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->numero_mission : old('numero_mission') }}">
                @error('numero_mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="type_de_mission">Type de mission <span class="text-danger">*</span></label>
                <input name="type_de_mission" type="text" class="form-control" id="type_de_mission"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->type_de_mission : old('type_de_mission') }}">
                @error('type_de_mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="numero_ordre_mission">Numéro d'ordre de mission <span class="text-danger">*</span></label>
                <input name="numero_ordre_mission" type="text" class="form-control" id="numero_ordre_mission"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->numero_ordre_mission : old('numero_ordre_mission') }}">
                @error('numero_ordre_mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="nature">Nature <span class="text-danger">*</span></label>
                <input name="nature" type="text" class="form-control" id="nature"
                    placeholder="Entrez le missions" value="{{ $dataToEdit ? $missions->nature : old('nature') }}">
                @error('nature')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- ? //////////////////////////////////////// --}}

            <div class="form-group col-lg-6 col-12">
                <label for="lieu">Lieu <span class="text-danger">*</span></label>
                <input name="lieu" type="text" class="form-control" id="lieu"
                    placeholder="Entrez le missions" value="{{ $dataToEdit ? $missions->lieu : old('lieu') }}">
                @error('lieu')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="data_ordre_mission">Date d'ordre de mission <span class="text-danger">*</span></label>
                <input name="data_ordre_mission" type="date" class="form-control" id="data_ordre_mission"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->data_ordre_mission : old('data_ordre_mission') }}">
                @error('data_ordre_mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="date_debut">Date début <span class="text-danger">*</span></label>
                <input name="date_debut" type="date" class="form-control" id="date_debut"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->date_debut : old('date_debut') }}">
                @error('date_debut')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="date_fin">Date fin <span class="text-danger">*</span></label>
                <input name="date_fin" type="date" class="form-control" id="date_fin"
                    placeholder="Entrez le missions" value="{{ $dataToEdit ? $missions->date_fin : old('date_fin') }}">
                @error('date_fin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="date_depart">Date depart <span class="text-danger">*</span></label>
                <input name="date_depart" type="date" class="form-control" id="date_depart"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->date_depart : old('date_depart') }}">
                @error('date_depart')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="heure_de_depart">Heure de depart <span class="text-danger">*</span></label>
                <input name="heure_de_depart" type="time" class="form-control" id="heure_de_depart"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->heure_de_depart : old('heure_de_depart') }}">
                @error('heure_de_depart')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="date_return">Date de return <span class="text-danger">*</span></label>
                <input name="date_return" type="date" class="form-control" id="date_return"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->date_return : old('date_return') }}">
                @error('date_return')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="heure_de_return">Heure de return <span class="text-danger">*</span></label>
                <input name="heure_de_return" type="time" class="form-control" id="heure_de_return"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->heure_de_return : old('heure_de_return') }}">
                @error('heure_de_return')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- ? //////////////////////////////////////// --}}

            <div class="form-group col-lg-6 col-12">
                <label for="Personnel">Moyens de transport <span class="text-danger">*</span></label>
                <select class="form-control" name="moyens_transports[]" multiple id="">
                    @foreach ($moyensTransport as $moyenTransport)
                        <option value="{{ $moyenTransport->id }}">{{ $moyenTransport->nom }}</option>
                    @endforeach
                </select>
                @error('moyens_transports')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-lg-6 col-12">
                <label for="marque">Marque <span class="text-danger">*</span></label>
                <input name="marque" type="text" class="form-control" id="marque"
                    placeholder="Entrez le missions" value="{{ $dataToEdit ? $missions->marque : old('marque') }}">
                @error('marque')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="puissance_fiscal">Puissance fiscal <span class="text-danger">*</span></label>
                <input name="puissance_fiscal" type="text" class="form-control" id="puissance_fiscal"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->puissance_fiscal : old('puissance_fiscal') }}">
                @error('puissance_fiscal')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-lg-6 col-12">
                <label for="numiro_plaque">Numiro plaque <span class="text-danger">*</span></label>
                <input name="numiro_plaque" type="text" class="form-control" id="numiro_plaque"
                    placeholder="Entrez le missions"
                    value="{{ $dataToEdit ? $missions->numiro_plaque : old('numiro_plaque') }}">
                @error('numiro_plaque')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>



    </div>

    <div class="card-footer">
        <a href="{{ route('missions.index') }}" class="btn btn-default">{{ __('app.cancel') }}</a>
        <button type="submit" class="btn btn-info">{{ $dataToEdit ? __('app.edit') : __('app.add') }}</button>
    </div>
</form>
