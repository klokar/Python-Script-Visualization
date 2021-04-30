<x-jet-form-section submit="uploadProcessor">
    <x-slot name="title">
        Nalaganje programa
    </x-slot>

    <x-slot name="description">
        Vnos direktorijev za izvajanje programa in uvoz datoteke.
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Ime programa, ki se prikaže pri izvajanju in izpiše v poročilu." />
            <x-jet-input id="program-name" type="text" class="mt-1 block w-full" wire:model.lazy="name"/>
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="e_path" value="Direktorij programa – ime direktorija, kjer bo datoteka s programom (.py)." />
            <x-jet-input id="program-path" type="text" class="mt-1 block w-full" wire:model.lazy="e_path"/>
            <x-jet-input-error for="e_path" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="e_path_result_figures" value="Mapa slik – ime direktorija, kjer bodo datoteke s slikami (.png)." />
            <x-jet-input id="program-path-result-figures" type="text" class="mt-1 block w-full" wire:model.lazy="e_path_result_figures"/>
            <x-jet-input-error for="e_path_result_figures" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="e_path_result_data" value="Mapa rezultatov – ime direktorija, kjer bodo datoteke s podatki (.csv)." />
            <x-jet-input id="program-path-result-data" type="text" class="mt-1 block w-full" wire:model.lazy="e_path_result_data"/>
            <x-jet-input-error for="e_path_result_data" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="level" value="Število nivojev za model SVM, če je ta definiran v programu." />
            @component('components.input-select', ['name' => 'level', 'data' => range(1, 3)])
            @endcomponent
            <x-jet-input-error for="level" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="comment" value="Komentar, ki se prikaže pri izvajanju programa in izpiše v poročilu." />
            <x-jet-input id="program-comment" type="text" class="mt-1 block w-full" wire:model.lazy="comment"/>
            <x-jet-input-error for="comment" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <label class="container flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-red-500">
                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-2 text-base leading-normal">Izberite datoteko</span>
                <input type="file" wire:model="file" class="hidden" />
            </label>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            Naloženo
        </x-jet-action-message>

        <x-jet-button>
            Naloži
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
