<x-jet-form-section submit="createExecution">
    <x-slot name="title">
        Izvajanje programa v Pythonu
    </x-slot>

    <x-slot name="description">
        <ul class="text-sm">
            <li class="italic text-gray-500">Izbira programa, podatkov, nastavitev velikosti testne množice v % in vpis dodatnih parametrov.</li>
        </ul>
        <div class="mt-6">
            <div>Primer uporabe parametrov:</div>
            <div class="text-sm mt-2 ml-2">
                <span class="font-semibold">Podani:</span>
                <span class="italic text-gray-500">'test1',70</span>
            </div>
            <div class="text-sm mt-2 ml-2">
                <span class="font-semibold">V programu bo:</span>
                <br>
                <span class="italic text-gray-500"> p1 = parameters[2][5] enako 'test1'</span>
                <br>
                <span class="italic text-gray-500"> p2 = parameters[2][6] enako 70</span>
            </div>
        </div>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="data_processor_id" value="Program" />
            @component('components.input-select', ['name' => 'data_processor_id', 'data' => $processors, 'dataId' => 'id', 'dataName' => 'name'])
            @endcomponent
            <x-jet-input-error for="data_processor_id" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="dataset_id" value="Podatki" />
            @component('components.input-select', ['name' => 'dataset_id', 'data' => $datasets, 'dataId' => 'id', 'dataName' => 'name'])
            @endcomponent
            <x-jet-input-error for="dataset_id" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="test_set_size" value="Velikost testne množice v %." />
            @component('components.input-select', ['name' => 'test_set_size', 'data' => range(1, 100)])
            @endcomponent
            <x-jet-input-error for="test_set_size," class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="parameters" value="Parametri, ločeni z vejico – opcijsko: če so v programu podani dodatni parametri, se vpišejo tukaj in so ločeni z vejico." />
            <x-jet-input id="execution-parameters" type="text" class="mt-1 block w-full" wire:model.lazy="parameters"/>
            <x-jet-input-error for="parameters" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="comment" value="Komentar, ki se izpiše v poročilu." />
            <x-jet-input id="execution-comment" type="text" class="mt-1 block w-full" wire:model.lazy="comment"/>
            <x-jet-input-error for="comment" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            Kreirano
        </x-jet-action-message>

        <x-jet-button>
            Kreiraj
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
