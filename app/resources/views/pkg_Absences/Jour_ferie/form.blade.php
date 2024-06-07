<form action="{{ isset($jourFerie) ? route('jourFerie.update', $jourFerie) : route('jourFerie.store') }}" method="POST">
    @csrf
    @if (isset($jourFerie))
        @method('PUT')
    @endif
    <div class="card-body">

        <div class="form-group">
            <label for="anneeJuridique">Année juridique</label>
            <select name="annee_juridique_id" class="form-control personnel" id="anneeJuridique">
                <option value="" selected disabled>--Veuillez choisir un année juridique--</option>
                @foreach ($anneeJuridiques as $anneeJuridique)
                    <option value="{{ $anneeJuridique->id }}"  {{ $jourFerie->annee_juridique_id === $anneeJuridique->id ? 'selected' : '' }}>
                        {{ $anneeJuridique->annee }}
                    </option>
                @endforeach
            </select>
            @error('annee_juridique_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jour férié affecté à: </label><br>
            <input type="hidden" name="is_formateur" value="false">
            <input type="hidden" name="is_administrateur" value="false">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="Jourferie-select-all">
                <label class="form-check-label" for="Jourferie-select-all">Tout sélectionner</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input jourFerie-checkbox" type="checkbox" name="is_formateur" id="is_formateur"
                    value="true" {{ isset($jourFerie) && $jourFerie->is_formateur ? 'checked' : '' }}>
                <label class="form-check-label" for="is_formateur">Formateur</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input jourFerie-checkbox" type="checkbox" name="is_administrateur"
                    id="is_administrateur" value="true" {{ isset($jourFerie) && $jourFerie->is_administrateur ? 'checked' : '' }}>
                <label class="form-check-label" for="is_administrateur">Adminstrateur</label>
            </div>
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input name="nom" type="text" class="form-control" id="nom" placeholder="nom jour férié"
                required value="{{ $jourFerie ? $jourFerie->nom : old('nom') }}">
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input name="date_debut" type="date" class="form-control" id="date_debut" placeholder="Date de début"
                required value="{{ $jourFerie ? $jourFerie->date_debut : old('date_debut') }}">
            @error('date_debut')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input name="date_fin" type="date" class="form-control" id="date_fin" placeholder="Date de début"
                required value="{{ $jourFerie ? $jourFerie->date_fin : old('date_fin') }}">
            @error('date_fin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="card-footer">
        <a href="{{ route('jourFerie.index') }}" class="btn btn-default">Annuler</a>
        <button type="submit"
            class="btn {{ isset($jourFerie) ? 'bg-teal' : 'btn-info' }}">{{ isset($jourFerie) ? __('app.edit') : __('app.add') }}</button>
    </div>

</form>

