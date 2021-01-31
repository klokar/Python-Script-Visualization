<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seznam izvajanj
        </h2>
        @component('components.ibutton', ['url' => '/execution/create', 'fa' => 'fa-plus', 'text' => 'Novo izvajanje'])
        @endcomponent
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                <table class="container table-auto mb-4">
                    <thead class="border-b">
                        <th class="text-left pb-5">Ime programa</th>
                        <th class="text-left pb-5">Podatki</th>
                        <th class="text-left pb-5">Podatki za evalvacijo</th>
                        <th class="text-left pb-5">Komentar</th>
                        <th class="text-left pb-5">Datum</th>
                        <th class="text-left pb-5">Akcije</th>
                    </thead>
                    <tbody>
                    @foreach ($executions as $execution)
                        <tr class="border-t">
                            <td class="py-2">{{ $execution->dataProcessor->name }}</td>
                            <td class="py-2">{{ $execution->dataset->name }}</td>
                            <td class="py-2">{{ $execution->dataset->name }}</td>
                            <td class="py-2">{{ $execution->comment }}</td>
                            <td class="py-2">{{ $execution->created_at->format('d.m.Y H:i') }}</td>
                            <td class="py-2 flex">
                                @component('components.ibutton', [
                                    'url' => '/execution/'.$execution->id,
                                    'fa' => 'fa-eye',
                                    'text' => '',
                                    'color' => 'green',
                                    'class' => 'mr-2',
                                    'tooltip' => 'Ogled poročila'
                                ])@endcomponent
                                @component('components.ibutton', [
                                    'url' => '/execution/'.$execution->id.'/output',
                                    'fa' => 'fa-align-left',
                                    'text' => '',
                                    'color' => 'gray',
                                    'class' => 'mr-2',
                                    'tooltip' => 'Izhodni podatki'
                                ])@endcomponent
                                @livewire('execution.run', ['execution_id' => $execution->id])
                                @livewire('execution.delete', ['execution_id' => $execution->id])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $executions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
