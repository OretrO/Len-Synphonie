@props(['href', 'variant' => 'primary'])

@php
    $variantClasses = match($variant) {
        'primary' => 'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300',
        'secondary' => 'text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300',
        default => 'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300',
    };
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'font-medium underline transition-colors duration-200 ' . $variantClasses]) }}
>
    {{ $slot }}
</a>

