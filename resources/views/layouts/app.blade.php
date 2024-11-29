@props([
    'title' => \App\CentralLogics\Helpers::appName(),
    'favicon' => \App\CentralLogics\Helpers::appFavicon(),
    'logo' => \App\CentralLogics\Helpers::appLogo(),

    'showNavigation' => true,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        @isset($rollingMessage)
            {{ $rollingMessage }}
        @endisset

        @if ($showNavigation)
            <header x-data="{ scrolled: false }" x-init="() => {
                window.addEventListener('scroll', () => {
                    scrolled = window.scrollY > 40;
                });
            }" :class="scrolled && 'bg-defaultBlue shadow-lg'"
                class="sticky inset-0 z-50 w-full transition-colors duration-300 -mt-0.5">
                @include('layouts.navigation')
            </header>
        @endif

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
