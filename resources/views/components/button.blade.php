@props(['href' => null, 'type' => 'button'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}>
        {{ $slot }}
    </button>
@endif
