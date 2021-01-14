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
                        <th class="text-left pb-5">Ime</th>
                        <th class="text-left pb-5">Algoritem</th>
                        <th class="text-left pb-5">Pot programa</th>
                        <th class="text-left pb-5">Pot podatkov</th>
                        <th class="text-left pb-5">Pot rezultatov</th>
                        <th class="text-left pb-5">Naloženo</th>
                        <th class="text-left pb-5">Akcije</th>
                    </thead>
                    <tbody>
                    @foreach ($processors as $processor)
                        <tr class="border-t">
                            <td class="py-2">{{ $processor->name }}</td>
                            <td class="py-2">{{ $processor->algorithm }}</td>
                            <td class="py-2">{{ $processor->processor_path }}</td>
                            <td class="py-2">{{ $processor->dataset_path }}</td>
                            <td class="py-2">{{ $processor->results_path }}</td>
                            <td class="py-2">{{ $processor->created_at->format('d.m.Y') }}</td>
                            <td class="py-2"><data-processor-actions processor-id={{$processor->id}}></data-processor-actions></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $processors->links() }}
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
                <div class="py-4">Seznam dependencijev</div>
                @if(empty($dependencies))
                    <div class="container">Dependenciji niso naloženi ali pa je napaka v datoteki!</div>
                @else
                    <table class="container table-auto mb-4">
                        <thead class="border-b">
                            <th class="text-left pb-5">Ime</th>
                            <th class="text-left pb-5">Verzija</th>
                        </thead>
                        <tbody>
                        @foreach ($dependencies as $name => $version)
                            <tr class="border-t">
                                <td class="py-2">{{ $name }}</td>
                                <td class="py-2">{{ $version }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

