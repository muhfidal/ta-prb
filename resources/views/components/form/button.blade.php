@props(['type' => 'submit', 'variant' => 'primary', 'text' => 'Simpan', 'fullWidth' => false])

@php
$baseClasses = 'inline-flex justify-center items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2';
$variantClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700 focus:ring-primary-500',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-primary-500',
    'danger' => 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
];
$widthClass = $fullWidth ? 'w-full' : '';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $widthClass]) }}
>
    {{ $text }}
</button>
