<select wire:model="{{ $name }}" class="border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
    <option selected>Izberi</option>
    @foreach ($data as $entry)
        <option wire:key="{{ $entry->{ $dataName ?? '' } ?? $entry }}"
                value="{{ $entry->{ $dataId ?? '' } ?? $entry }}">
            {{ $entry->{ $dataName ?? ''} ?? $entry }}
        </option>
    @endforeach
</select>
