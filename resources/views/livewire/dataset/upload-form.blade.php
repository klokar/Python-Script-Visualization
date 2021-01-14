<x-jet-form-section submit="uploadDataset">
    <x-slot name="title">
        Nalaganje podatkov
    </x-slot>

    <x-slot name="description">
        Tukaj lahko naložite nabor podatkov, ki se bo uporabil ob samem izvajanju.
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Naslov podatkov" />
            <x-jet-input id="dataset-name" type="text" class="mt-1 block w-full" wire:model.lazy="name"/>
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
{{--            <x-jet-label for="file" value="Datoteka s podatki" />--}}
{{--            <x-jet-input id="dataset-file" type="file" class="mt-1 block w-full" wire:model="file"/>--}}
{{--            <x-jet-input-error for="file" class="mt-2" />--}}
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
