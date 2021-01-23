<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rezultati izvajanja
        </h2>
        <div class="flex">
            @component('components.ibutton', [
                'url' => '/execution/'.$execution->id.'/output',
                'fa' => 'fa-align-left',
                'text' => '',
                'color' => 'gray',
                'class' => 'mr-2'
            ])@endcomponent
        </div>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 pb-6">
                <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Parametri izvajanja</div>
                <table class="container table-auto mb-4">
                    @foreach ($p_details as $key => $value)
                        <tr class="border-t">
                            <td class="py-2">{{ $key }}</td>
                            <td class="py-2">{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 pb-6">
                <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Podatki o evalvaciji</div>
                <table class="container table-auto mb-4">
                    @foreach ($e_details as $key => $value)
                        <tr class="border-t">
                            <td class="py-2">{{ $key }}</td>
                            <td class="py-2">{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 pb-6">
                <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Vizualizacija</div>
                <div class="grid grid-flow-row grid-cols-3 grid-rows-4 gap-4">
{{--                    <div class="bg-auto md:bg-contain"></div>--}}
                    @foreach ($images as $path)
                        <img src="/{{ $path }}">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
