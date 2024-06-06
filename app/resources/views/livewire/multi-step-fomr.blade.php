<form @if ($dataToEdit == 'create') wire:submit.prevent="store" @else wire:submit.prevent="update" @endif>
    <div class="card-body">
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="progress-container">
                        <div class="progress-bar-container">
                            <div class="progress-step active">
                                <div class="progress-circle {{ $currentStep == 1 ? 'bg-info' : '' }}">1</div>
                                <div class="progress-title">Les Informations</div>
                            </div>
                            <div class="progress-bar-line"></div>
                            <div class="progress-step">
                                <div class="progress-circle {{ $currentStep == 2 ? 'bg-info' : '' }}">2</div>
                                <div class="progress-title">Planification</div>
                            </div>
                            <div class="progress-bar-line"></div>
                            <div class="progress-step">
                                <div class="progress-circle {{ $currentStep == 3 ? 'bg-info' : '' }}">3</div>
                                <div class="progress-title">Moyens des transports</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">

            {{-- ? Step One --}}
            @if ($currentStep == 1)
                <fieldset class="border col-lg-12 mb-5 p-3">
                    <legend>Les Informations de mission</legend>
                    <div class="row" id="stepOne">
                        <div class="form-group col-lg-6 col-12">
                            <label for="Personnel">Personnel <span class="text-danger">*</span></label>
                            <select class="js-example-basic-multiple" wire:model="users" style="width: 100%;"
                                multiple="multiple">
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
                            <input wire:model="numero_mission" type="number" class="form-control" id="numero_mission"
                                placeholder="Entrez le missions">
                            @error('numero_mission')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="type_de_mission">Type de mission <span class="text-danger">*</span></label>
                            <input wire:model="type_de_mission" type="text" class="form-control" id="type_de_mission"
                                placeholder="Entrez le missions">
                            @error('type_de_mission')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="numero_ordre_mission">Numéro d'ordre de mission <span
                                    class="text-danger">*</span></label>
                            <input wire:model="numero_ordre_mission" type="number" class="form-control"
                                id="numero_ordre_mission" placeholder="Entrez le missions">
                            @error('numero_ordre_mission')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="nature">Nature </label>
                            <input wire:model="nature" type="text" class="form-control" id="nature"
                                placeholder="Entrez le missions">
                            @error('nature')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>
            @endif


            {{-- ? Step two --}}
            @if ($currentStep == 2)
                <fieldset class="border col-lg-12 mb-5 p-3">
                    <legend>Planification de mission</legend>
                    <div class="row" id="stepTwo">
                        <div class="form-group col-lg-6 col-12">
                            <label for="lieu">Lieu <span class="text-danger">*</span></label>
                            <input wire:model="lieu" type="text" class="form-control" id="lieu"
                                placeholder="Entrez le missions">
                            @error('lieu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="data_ordre_mission">Date d'ordre de mission <span
                                    class="text-danger">*</span></label>
                            <input wire:model="data_ordre_mission" type="date" class="form-control"
                                id="data_ordre_mission" placeholder="Entrez le missions">
                            @error('data_ordre_mission')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="date_debut">Date début <span class="text-danger">*</span></label>
                            <input wire:model="date_debut" type="date" class="form-control" id="date_debut"
                                placeholder="Entrez le missions">
                            @error('date_debut')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="date_fin">Date fin <span class="text-danger">*</span></label>
                            <input wire:model="date_fin" type="date" class="form-control" id="date_fin"
                                placeholder="Entrez le missions">
                            @error('date_fin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="date_depart">Date depart <span class="text-danger">*</span></label>
                            <input wire:model="date_depart" type="date" class="form-control" id="date_depart"
                                placeholder="Entrez le missions">
                            @error('date_depart')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="heure_de_depart">Heure de depart <span class="text-danger">*</span></label>
                            <input wire:model="heure_de_depart" type="time" class="form-control"
                                id="heure_de_depart" placeholder="Entrez le missions">
                            @error('heure_de_depart')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="date_return">Date de return <span class="text-danger">*</span></label>
                            <input wire:model="date_return" type="date" class="form-control" id="date_return"
                                placeholder="Entrez le missions">
                            @error('date_return')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-12">
                            <label for="heure_de_return">Heure de return <span class="text-danger">*</span></label>
                            <input wire:model="heure_de_return" type="time" class="form-control"
                                id="heure_de_return" placeholder="Entrez le missions">
                            @error('heure_de_return')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>
            @endif

            {{-- ? Step three --}}
            @if ($currentStep == 3)
                @foreach ($users as $user)
                    <fieldset class="border col-lg-12 mb-5 p-3">
                        <legend>{{ $this->getUserNameById($user) }}</legend>
                        <div class="row" id="stepThree">
                            <div class="form-group col-lg-6 col-12">
                                <label for="Personnel">Moyens de transport <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model="moyens_transports.{{ $user }}"
                                    id="">
                                    @foreach ($moyensTransportsValues as $item)
                                        <option value="{{ $item->id }}">{{ $item->nom }}</option>
                                    @endforeach
                                </select>
                                @error('moyens_transports.' . $user)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="marque">Marque <span class="text-danger">*</span></label>
                                <input wire:model="marque.{{ $user }}" type="text" class="form-control"
                                    id="marque" placeholder="Entrez le missions">
                                @error('marque.' . $user)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                <label for="puissance_fiscal">Puissance fiscal <span
                                        class="text-danger">*</span></label>
                                <input wire:model="puissance_fiscal.{{ $user }}" type="text"
                                    class="form-control" id="puissance_fiscal" placeholder="Entrez le missions">
                                @error('puissance_fiscal.' . $user)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                <label for="numiro_plaque">Numiro plaque <span class="text-danger">*</span></label>
                                <input wire:model="numiro_plaque.{{ $user }}" type="text"
                                    class="form-control" id="numiro_plaque" placeholder="Entrez le missions">
                                @error('numiro_plaque.' . $user)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                @endforeach
            @endif


        </div>



    </div>

    <div class="card-footer">
        @if ($currentStep == 2 || $currentStep == 3)
            <a class="btn btn-default" wire:click="decreaseStep()">Précédent</a>
        @endif
        @if ($currentStep == 1 || $currentStep == 2)
            <a class="btn btn-default" wire:click="increaseStep()">Suivant</a>
        @endif
        @if ($currentStep == 3)
            <button type="submit"
                class="btn btn-info">{{ $dataToEdit == 'create' ? __('app.add') : __('app.edit') }}</button>
        @endif

    </div>
</form>
<script>
    // Multi-select boxes
    $(document).ready(function() {
        alert('aaaa')
        $('.js-example-basic-multiple').select2();
    });
</script>
