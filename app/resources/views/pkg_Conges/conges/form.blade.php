<div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="custom-tabs-one-form-tab">
    <form method="POST" action="{{ isset($conge) ? route('conges.update', $conge->id) : route('conges.store') }}">
        @csrf
        @if (isset($conge))
            @method('PUT') <!-- Use PUT method for update -->
        @endif

        <div class="card-body">
            <input type="hidden" id="conge_id" value="{{isset($conge) ? $conge->id : '' }}">
            <input type="hidden" value="{{$etablissement}}" id="inpEtablissement">
            <!-- Personnel -->
            <div class="form-group">
                <label for="exampleInputPersonnel">Personnel: <span class="text-danger">*</span></label>
                <select name="personnel_id" class="form-control js-example-basic-single" id="personnel_id">
                    @forelse ($personnels as $personnel)
                        @php
                            $selected = old('personnel_id', isset($conge) ? $conge->personnels->contains($personnel->id) : '') == $personnel->id ? 'selected' : '';
                        @endphp
                        <option value="{{ $personnel->id }}" {{ $selected }}>
                            {{ $personnel->nom }} {{ $personnel->prenom }}
                        </option>
                    @empty
                        <option value="">No personnels available</option>
                    @endforelse
                </select>
                
                @error('personnel_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            

            <!-- Motif -->
            <div class="form-group">
                <label for="inputMotif">Motif: <span class="text-danger">*</span></label>
                <select name="motif_id" class="form-control" id="inputMotif">
                    @foreach ($motifs as $motif)
                        <option value="{{ $motif->id }}"
                            {{ old('motif_id', isset($conge) ? $conge->motif_id : '') == $motif->id ? 'selected' : '' }}>
                            {{ $motif->nom }}
                        </option>
                    @endforeach
                </select>
                @error('motif_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date de début -->
            <div class="form-group">
                <label for="inputStartDate">Date de début: <span class="text-danger">*</span></label>
                <input name="date_debut" type="date" class="form-control" id="inputStartDate"
                    value="{{ old('date_debut', isset($conge) ? $conge->date_debut : '') }}">
                @error('date_debut')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date de fin -->
            <div class="form-group">
                <label for="inputEndDate">Date de fin: <span class="text-danger">*</span></label>
                <input name="date_fin" type="date" class="form-control" id="inputEndDate"
                    value="{{ old('date_fin', isset($conge) ? $conge->date_fin : '') }}">
                @error('date_fin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nombre des jours -->
            {{-- <div class="form-group">
                <label for="nobreJours">Nombre des jours reaston:</label>
                <input type="number" name="nobreJours" id="nobreJours" class="form-control {{ $joursRestantsFirstYear < 0 ? 'bg-danger' : '' }}" id="nobreJours"
                value="{{ old('nobreJours', $joursRestantsFirstYear) }}" readonly>
            </div> --}}
        </div>

        <div class="card-footer w-100 d-flex justify-content-end">
            <a href="{{ route('conges.index') }}" class="btn btn-default mr-2">Annuler</a>
            <button type="submit" class="btn {{ isset($conge) ? 'bg-teal' : 'btn-info' }}">
                {{ isset($conge) ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>
    </form>
</div>
