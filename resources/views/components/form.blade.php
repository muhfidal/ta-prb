@props([
    'action' => '',
    'method' => 'POST',
    'enctype' => 'application/x-www-form-urlencoded'
])

<form action="{{ $action }}" method="{{ $method }}" enctype="{{ $enctype }}" {{ $attributes->merge(['class' => 'space-y-6']) }}>
    @csrf
    @if(strtoupper($method) === 'PUT' || strtoupper($method) === 'PATCH' || strtoupper($method) === 'DELETE')
        @method($method)
    @endif

    {{ $slot }}
</form>
