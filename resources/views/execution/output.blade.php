<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Output
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black text-white shadow-xl sm:rounded-lg sm:p-6">
                @foreach ($output as $line)
                    <div class="overflow-ellipsis overflow-hidden ...">
                        @if($line->level === "E")
                            <span class="text-red-500">> {!! $line->message !!}</span>
                        @elseif($line->level === "S")
                            <span class="text-green-500">> {!! $line->message !!}</span>
                        @else
                            <span>> {!! $line->message !!}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
