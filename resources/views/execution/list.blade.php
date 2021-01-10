<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seznam izvajanj
        </h2>
        <button class="px-4 py-2 rounded-md transition ease-in-out duration-150 font-semibold text-xs text-white uppercase tracking-widest bg-red-500">
            <a href="/execution/create"></a>
            <i class="fa fa-plus"></i>
            Novo izvajanje
        </button>
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
{{--                <div class="grid grid-cols-5 gap-1">--}}
{{--                    <div class="font-bold pb-2">Ime programa</div>--}}
{{--                    <div class="font-bold pb-2">Naslov podatkov</div>--}}
{{--                    <div class="font-bold pb-2">Komentar</div>--}}
{{--                    <div class="font-bold pb-2">Datum</div>--}}
{{--                    <div class="font-bold pb-2">Akcije</div>--}}
{{--                    @foreach ($executions as $execution)--}}
{{--                        <div>{{ $execution->dataProcessor->name }}</div>--}}
{{--                        <div>{{ $execution->dataset->name }}</div>--}}
{{--                        <div>{{ $execution->comment }}</div>--}}
{{--                        <div>{{ $execution->created_at->format('d.m.Y H:i') }}</div>--}}
{{--                        <div><extension-actions execution-id={{$execution->id}}></extension-actions></div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</x-app-layout>
