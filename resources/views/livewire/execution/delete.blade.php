<div>
    <x-jet-danger-button wire:click="confirmDeletion" wire:loading.attr="disabled" class="tooltip">
        <i class="fa fa-times"></i>
        <span class='tooltip-text bg-gray-800 text-white -mt-16 ml-9 rounded'>Izbriši</span>
    </x-jet-danger-button>
    <x-jet-confirmation-modal wire:model="confirming">
        <x-slot name="title">
            {{ __('Delete entry') }}
        </x-slot>
        <x-slot name="content">
            {{ __('Are you sure you sure?') }}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirming')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteEntry" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
