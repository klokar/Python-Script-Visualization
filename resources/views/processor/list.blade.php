<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seznam naloženih programov
        </h2>
        @component('components.ibutton', ['url' => '/processor/create', 'fa' => 'fa-plus', 'text' => 'Naloži'])
        @endcomponent
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                <table class="container table-auto mb-4">
                    <thead class="border-b">
                        <th class="text-left pb-5">Ime programa</th>
                        <th class="text-left pb-5">Direktorij programa</th>
                        <th class="text-left pb-5">Slike (.png)</th>
                        <th class="text-left pb-5">Rezultati (.csv)</th>
                        <th class="text-left pb-5">Nivoji SVM</th>
                        <th class="text-left pb-5">Posodobljeno</th>
                        <th class="text-left pb-5">Akcije</th>
                    </thead>
                    <tbody>
                    @foreach ($processors as $processor)
                        <tr class="border-t">
                            <td class="py-2">{{ $processor->name }}</td>
                            <td class="py-2">{{ $processor->e_path }}</td>
                            <td class="py-2">{{ $processor->e_path_result_figures }}</td>
                            <td class="py-2">{{ $processor->e_path_result_data }}</td>
                            <td class="py-2">{{ $processor->level }}</td>
                            <td class="py-2">{{ $processor->updated_at->format('d.m.Y') }}</td>
                            <td class="py-2 flex">
                                @component('components.ibutton', [
                                    'url' => '/processor/'.$processor->id.'/edit',
                                    'fa' => 'fa-exchange-alt',
                                    'text' => '',
                                    'color' => 'gray',
                                    'class' => 'mr-2',
                                    'tooltip' => 'Zamenjava datoteke'
                                ])@endcomponent
                                @livewire('processor.delete', ['processor_id' => $processor->id])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $processors->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

