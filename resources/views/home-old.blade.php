<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                @if ((!isset($apiData['status']) || !$apiData['status']) && (!isset($data['status']) || !$data['status']))
                    <header class="grid grid-cols-1 items-center gap-2 py-10 lg:grid-cols-1">
                        <h2 class="text-3xl text-center font-bold antialiased text-gray-900 dark:text-gray-100">
                            {{ $data['name'] ?? $apiData['name'] }}
                        </h2>
                        <p class="text-base text-center font-bold antialiased text-gray-500 dark:text-gray-400">
                            {{ $data['domain'] ?? $apiData['domain'] }}
                        </p>
                    </header>
                @endif

                @if ((isset($apiData['status']) && $apiData['status']) || (isset($data['status']) && $data['status']))
                    <main class="mt-6">
                        <div class="flex flex-wrap mx-auto">

                            <div id="status-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20]  lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20] cursor-pointer mx-auto">
                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        @if ($apiData['status'] || $data['status'])
                                            <div
                                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 sm:size-6 stroke-red-500 stroke-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div
                                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-green-500/10 sm:size-16">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 sm:size-6 stroke-green-500 stroke-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2 class="text-xl font-semibold text-black dark:text-white">
                                                {{ ($apiData['status'] || $data['status']) ? 'Restaurant is Closed' : 'The restaurant is currently open.' }}
                                            </h2>

                                            <p class="mt-4 text-sm/relaxed prose dark:prose-invert">
                                                {!! $apiData['status'] ? $apiData['status_msg'] : $data['status_msg'] !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </main>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
