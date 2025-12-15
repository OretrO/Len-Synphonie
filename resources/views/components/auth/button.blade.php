@props(['type' => 'submit', 'variant' => 'primary'])

@php
    $baseClasses = 'w-full py-3 px-4 rounded-lg font-semibold text-white transition-all duration-200 focus:outline-none focus:ring-4 disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = match($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-300 dark:focus:ring-gray-800',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-300 dark:focus:ring-green-800',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-300 dark:focus:ring-red-800',
        default => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-300 dark:focus:ring-blue-800',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}
>
    {{ $slot }}
</button>

