@props(['title', 'description', 'caption', 'bgImg'])

<section class="bg-center bg-cover h-[100svh] -mt-20" style="background-image: url('{{ $bgImg }}')">
    <div class="w-full h-full flex justify-center items-center bg-[#00000026]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative text-center mt-20">
            <h1
                class="max-w-2xl mx-auto text-center font-manrope font-bold text-4xl text-defaultGreen mb-5 md:text-5xl leading-[50px]">
                {{ $title }}
            </h1>
            <div
                class="max-w-2xl mx-auto text-center text-xl font-normal leading-7 text-gray-300 mb-9 prose dark:prose-invert">
                {!! $description !!}
            </div>
            <div class="flex flex-wrap gap-5 justify-center w-full">
                <x-primary-button>
                    <x-heroicon-m-calendar-days class="mr-1 h-5 w-5" />Reservation
                </x-primary-button>
                <x-secondary-button>
                    <x-heroicon-m-list-bullet class="mr-1 h-5 w-5" /> Reservation Menu
                </x-secondary-button>
            </div>
            <div class="my-10 flex items-center justify-center gap-5">
                <div class="h-0.5 bg-defaultWhite min-w-8 md:min-w-12 grow"></div>
                <h3
                    class="max-w-2xl text-center uppercase font-manrope font-bold text-xl text-defaultGreen md:text-2xl">
                    {{ $caption }}
                </h3>
                <div class="h-0.5 bg-defaultWhite min-w-8 md:min-w-12 grow"></div>
            </div>
        </div>
    </div>
</section>
