@props(['name', 'label', 'checked' => false])

<div class="flex items-center mb-4">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600']) }}
    >
    <label for="{{ $name }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>
</div>

