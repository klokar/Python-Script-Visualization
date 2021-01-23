<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Podatki o izvajanju
        </h2>
        <div class="flex">
            @component('components.ibutton', [
                'url' => '/execution/'.$execution->id,
                'fa' => 'fa-eye',
                'text' => '',
                'color' => 'green',
                'class' => 'mr-2'
            ])@endcomponent
            @livewire('execution.run', ['execution_id' => $execution->id])
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black text-white shadow-xl sm:rounded-lg sm:p-6">
                @switch($execution->status)
                    @case(0)
                        <div class="text-center">
                            <span class="text-red-500">Program še ni bil pognan</span>
                        </div>
                        @break
                    @case(1)
                        <div class="text-center">
                            <span><i class="fas fa-spinner fa-pulse mr-4"></i>Program je v vrsti za izvajanje</span>
                        </div>
                        @break
                    @case(2)
                    @case(3)
                        @foreach ($output as $line)
                            <div class="overflow-ellipsis overflow-hidden ...">
                                @if($line->level === "E")
                                    ><span class="ml-2 text-red-500">{!! $line->message !!}</span>
                                @elseif($line->level === "S")
                                    ><span class="ml-2" style="color: #58e810">{!! $line->message !!}</span>
                                @else
                                    ><span class="ml-2">{!! $line->message !!}</span>
                                @endif
                            </div>
                        @endforeach
                        @if($execution->status == 2)
                            <div class="flex justify-center mt-2">
                                <div class="loader-dots block relative w-20 h-5 mt-2">
                                    <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-white"></div>
                                    <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-white"></div>
                                    <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-white"></div>
                                    <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-white"></div>
                                </div>
                            </div>
                        @endif
                @endswitch
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    window.setTimeout(function () {
        window.location.reload();
    }, 10000);
</script>
