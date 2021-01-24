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
    <div x-data="{}" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 pb-6">
                <div class="px-6 py-4 rounded-b-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6">Vizualizacija</div>
                <div class="grid grid-flow-row grid-cols-3 grid-rows-4 gap-4">
                    @foreach ($images as $path)
                        <a @click="$dispatch('img-modal', {  imgModalSrc: '/{{ $path }}', imgModalDesc: '' })" class="cursor-pointer">
                            <img alt="Slika" class="object-fit w-full" src="/{{ $path }}">
                        </a>
                    @endforeach
                </div>
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
