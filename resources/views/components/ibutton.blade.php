<a href="{{ $url }}" class="px-4 py-2 rounded-md transition ease-in-out duration-150 font-semibold text-xs text-white uppercase tracking-widest
@if (empty($color)) bg-red-500 @else bg-{{ $color }}-500 @endif
@if (!empty($class)) {{ $class }} @endif tooltip">
    <i class="fa {{ $fa }}"></i>
    {{ $text }}
    @if (!empty($tooltip))<span class='tooltip-text bg-gray-800 text-white -mt-10 -ml-5 rounded'>{{ $tooltip }}</span>@endif
</a>
