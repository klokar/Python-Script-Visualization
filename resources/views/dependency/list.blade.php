<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Python-knjižnice
        </h2>
        @component('components.ibutton', ['url' => '/dependency/create', 'fa' => 'fa-plus', 'text' => 'Dodaj'])
        @endcomponent
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                @if(empty($dependencies))
                    <div class="container">Knjižnice niso naložene ali pa je napaka v datoteki!</div>
                @else
                    <table class="container table-auto mb-4">
                        <thead class="border-b">
                        <th class="text-left pb-5">Ime knjižnice</th>
                        <th class="text-left pb-5">Verzija</th>
                        <th class="text-left pb-5">Akcije</th>
                        </thead>
                        <tbody>
                        @foreach ($dependencies as $dependency)
                            <tr class="border-t">
                                <td class="py-2">{{ $dependency->name }}</td>
                                <td class="py-2">{{ $dependency->version }}</td>
                                <td class="py-2">
                                    @livewire('dependency.delete', ['dependency_id' => $dependency->id])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

