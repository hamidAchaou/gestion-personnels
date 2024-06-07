<form action="{{ isset($absence) ? route('absence.update', $absence) : route('absence.store') }}" method="POST">
    @csrf
    @if (isset($absence))
        @method('PUT')
    @endif
    <div class="card-body">

        <div class="form-group">
            <label for="exampleInputProject">Personnels</label>
            <select name="personnel" class="form-control personnel" id="personnel">
                <option value="" selected disabled>--Veuillez choisir un personnel--</option>
                @foreach ($personnels as $personnel)
                    <option value="{{ $personnel->id }}"
                        {{ isset($absence) && $absence->personnel->id === $personnel->id ? 'selected' : '' }}>
                        {{ $personnel->nom }} {{ $personnel->prenom }}
                    </option>
                @endforeach
            </select>
            @error('personnel')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="exampleInputProject">Motif</label>
            <select name="motif" class="form-control" id="exampleInputProject">
                <option value="" selected disabled>--Veuillez choisir un motif--</option>
                @foreach ($motifs as $motif)
                    <option value="{{ $motif->id }}" {{ isset($absence) && $absence->motif->id === $motif->id ? 'selected' : '' }}>
                        {{ $motif->nom }}
                    </option>
                @endforeach
            </select>
            @error('motif')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Date de début</label>
            <input name="date_debut" type="date" class="form-control" id="exampleInputPassword1"
                placeholder="Date de début" required value="{{ isset($absence) && $absence ? $absence->date_debut : old('date_debut') }}">
            @error('date_debut')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Date de fin</label>
            <input name="date_fin" type="date" class="form-control" id="exampleInputPassword1"
                placeholder="Date de début" required value="{{ isset($absence) && $absence ? $absence->date_fin : old('date_fin') }}">
            @error('date_fin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="Remarques">Remarques</label>
            <textarea name="remarques" class="form-control" rows="7" id="Remarques" placeholder="Remarques">
                {{ isset($absence) && $absence ? $absence->remarques : old('remarques') }}
            </textarea>
        </div>


    </div>

    <div class="card-footer">
        <a href="{{ route('absence.index') }}" class="btn btn-default">Annuler</a>
        <button type="submit"
            class="btn {{ isset($absence) ? 'bg-teal' : 'btn-info' }}">{{ isset($absence) ? __('app.edit') : __('app.add') }}</button>
    </div>

</form>
