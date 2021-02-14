<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nalaganje zunanjih knjižnic
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{--            <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Dodaj posamezno knjižnico</div>--}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                @livewire('dependency.add-form')
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{--            <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Naloži datoteko</div>--}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                @livewire('dependency.upload-form')
            </div>
        </div>
    </div>
</x-app-layout>

