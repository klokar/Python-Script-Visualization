<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rezultati izvajanja
        </h2>
        <div class="flex">
            @component('components.ibutton', [
                'url' => '/execution/'.$execution->id.'/output',
                'fa' => 'fa-align-left',
                'text' => 'Izhodni podatki',
                'color' => 'gray',
                'class' => 'mr-2'
            ])@endcomponent
            @component('components.ibutton', [
                'url' => '/execution/'.$execution->id.'/download-files',
                'fa' => 'fa-folder',
                'text' => 'Prenos datotek',
                'color' => 'red',
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
    <div x-data="{}" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 pb-6">
                <form method="POST" action="/execution/{{ $execution->id }}/report">
                    @csrf

                    <div class="flex justify-between">
                        <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Vizualizacija in generiranje PDF poročila</div>
                        <div>
                            <button name="action" value="download" class="h-8 mt-4 px-4 py-2 rounded-md transition ease-in-out duration-150 font-semibold text-xs text-white uppercase tracking-widest bg-red-500">
                                <i class="fa fa-arrow-down"></i>
                                Prenesi poročilo
                            </button>
                            <button name="action" value="view" class="h-8 mt-4 px-4 py-2 rounded-md transition ease-in-out duration-150 font-semibold text-xs text-white uppercase tracking-widest bg-green-500">
                                <i class="fa fa-eye"></i>
                                Poglej poročilo
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="title" class="mt-2 block font-medium text-sm text-gray-700">Naslov</label>
                        <input name="title" type="text" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <label for="description" class="mt-2 block font-medium text-sm text-gray-700">Besedilo</label>
                        <textarea name="description" type="text" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        </textarea>
                    </div>
                    <div class="mt-8 grid grid-flow-row grid-cols-3 grid-rows-4 gap-x-4">
                        @foreach ($images as $hash => $path)
                            <div>
                                <a @click="$dispatch('img-modal', {  imgModalSrc: '/{{ $path }}', imgModalDesc: '' })" class="cursor-pointer">
                                    <img alt="Slika" class="object-fit w-full" src="/{{ $path }}">
                                </a>
                                <div class="px-3 container grid grid-flow-row grid-rows-2 gap-x-2" style="grid-template-columns: 50px auto;">
                                    <label class="mt-2 block font-medium text-sm text-gray-700">Izberi</label>
                                    <input name="{{ $hash }}-check" type="checkbox" class="mt-2 rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <label class="mt-2 block font-medium text-sm text-gray-700">Opis</label>
                                    <input name="{{ $hash }}-title" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div x-data="{ imgModal : false, imgModalSrc : '', imgModalDesc : '' }">
        <template @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;" x-if="imgModal">
            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-100" x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-100"
                 x-on:click.away="imgModalSrc = ''" class="p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
                <div @click.away="imgModal = ''" class="flex flex-col max-w-3xl max-h-full overflow-auto">
                    <div class="z-50">
                        <button @click="imgModal = ''" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                            <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-2">
                        <img :alt="imgModalSrc" class="object-contain h-1/2-screen" :src="imgModalSrc">
                        <p x-text="imgModalDesc" class="text-center text-white"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
