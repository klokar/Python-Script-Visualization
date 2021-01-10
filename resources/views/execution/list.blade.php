<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seznam izvajanj
        </h2>
        @component('components.ibutton', ['url' => '/execution/create', 'fa' => 'fa-plus', 'text' => 'Novo izvajanje'])
        @endcomponent
{{--        @ibutton(['url' => '/execution/create', 'fa' => 'fa-plus', 'text' => 'Novo izvajanje'])--}}
{{--        @endibutton--}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                <table class="container table-auto mb-4">
                    <thead class="border-b">
                        <th class="text-left pb-5">Ime programa</th>
                        <th class="text-left pb-5">Naslov podatkov</th>
                        <th class="text-left pb-5">Komentar</th>
                        <th class="text-left pb-5">Datum</th>
                        <th class="text-left pb-5">Akcije</th>
                    </thead>
                    <tbody>
                    @foreach ($executions as $execution)
                        <tr class="border-t">
                            <td class="py-2">{{ $execution->dataProcessor->name }}</td>
                            <td class="py-2">{{ $execution->dataset->name }}</td>
                            <td class="py-2">{{ $execution->comment }}</td>
                            <td class="py-2">{{ $execution->created_at->format('d.m.Y H:i') }}</td>
                            <td class="py-2"><extension-actions execution-id={{$execution->id}}></extension-actions></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $executions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
