<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seznam podatkov
        </h2>
        @component('components.ibutton', ['url' => '/dataset/create', 'fa' => 'fa-plus', 'text' => 'Naloži'])
        @endcomponent
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                <table class="container table-auto mb-4">
                    <thead class="border-b">
                        <th class="text-left pb-5">Ime</th>
                        <th class="text-left pb-5">Ime datoteke</th>
                        <th class="text-left pb-5">Velikost</th>
                        <th class="text-left pb-5">Naloženo</th>
                        <th class="text-left pb-5">Akcije</th>
                    </thead>
                    <tbody>
                    @foreach ($datasets as $dataset)
                        <tr class="border-t">
                            <td class="py-2">{{ $dataset->name }}</td>
                            <td class="py-2">{{ $dataset->original_name }}</td>
                            <td class="py-2">{{ $dataset->formatted_size }}</td>
                            <td class="py-2">{{ $dataset->created_at->format('d.m.Y H:i') }}</td>
                            <td class="py-2">
                                @livewire('dataset.delete', ['dataset_id' => $dataset->id])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $datasets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

