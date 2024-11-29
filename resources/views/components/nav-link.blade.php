@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-green-400 dark:border-green-600 text-base font-medium leading-5 text-green-500 dark:text-green-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-base font-medium leading-5 text-gray-300 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300 hover:border-green-500 dark:hover:border-green-700 focus:outline-none focus:text-green-700 dark:focus:text-green-300 focus:border-green-300 dark:focus:border-green-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
