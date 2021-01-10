<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo izvajanje
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5 sm:p-6">
{{--                <form action="/execution" method="post">--}}
{{--                    @csrf--}}
{{--                    <select name="data_processor_id" class="form-control">--}}
{{--                        @foreach ($processors as $processor)--}}
{{--                            <option value="{{ $processor->id }}">{{ $processor->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <select name="dataset_id" class="form-control">--}}
{{--                        @foreach ($datasets as $dataset)--}}
{{--                            <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <input type="text" name="comment" id="execution-comment" placeholder="Komentar" class="form-control">--}}
{{--                    <input type="text" name="parameters" id="execution-parameters" placeholder="Parametri" class="form-control">--}}
{{--                    <button class="btn btn-success" type="submit" id="create-execution">Kreiraj</button>--}}
{{--                </form>--}}
                @livewire('execution.create-form', ['processors' => $processors, 'datasets' => $datasets])


{{--                <div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>--}}
{{--                    <x-jet-section-title>--}}
{{--                        <x-slot name="title">{{ $title }}</x-slot>--}}
{{--                        <x-slot name="description">{{ $description }}</x-slot>--}}
{{--                    </x-jet-section-title>--}}

{{--                    <div class="mt-5 md:mt-0 md:col-span-2">--}}
{{--                        <form wire:submit.prevent="{{ $submit }}">--}}
{{--                            <div class="shadow overflow-hidden sm:rounded-md">--}}
{{--                                <div class="px-4 py-5 bg-white sm:p-6">--}}
{{--                                    <div class="grid grid-cols-6 gap-6">--}}
{{--                                        {{ $form }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                @if (isset($actions))--}}
{{--                                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">--}}
{{--                                        {{ $actions }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</x-app-layout>

