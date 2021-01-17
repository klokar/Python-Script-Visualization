<a href="{{ $url }}" class="px-4 py-2 rounded-md transition ease-in-out duration-150 font-semibold text-xs text-white uppercase tracking-widest
@if (empty($color)) bg-red-500 @else bg-{{ $color }}-500 @endif
@if (!empty($class)) {{ $class }} @endif">
    <i class="fa {{ $fa }}"></i>
    {{ $text }}
</a>
