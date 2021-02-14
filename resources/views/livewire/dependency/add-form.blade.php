<x-jet-form-section submit="addDependency">
    <x-slot name="title">
        Dodajanje knjižnice
    </x-slot>

    <x-slot name="description">
        Tukaj lahko bo na seznam dodan spodnji vnos.
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Ime knjižnice" />
            <x-jet-input id="dependency-name" type="text" class="mt-1 block w-full" wire:model.lazy="name"/>
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="version" value="Verzija" />
            <x-jet-input id="dependency-version" type="text" class="mt-1 block w-full" wire:model.lazy="version"/>
            <x-jet-input-error for="version" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            Dodano
        </x-jet-action-message>

        <x-jet-button>
            Dodaj
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
