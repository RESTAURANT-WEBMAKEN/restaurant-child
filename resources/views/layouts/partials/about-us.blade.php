@props(['title', 'description', 'frontImg', 'bgImg'])

<section class="lg:pt-20 pt-0 h-full bg-indigo-50" id="about-us">
    <div class="rounded-2xl py-10 overflow-hidden m-5 lg:m-0 2xl:py-16 xl:py-8  lg:rounded-tl-2xl lg:rounded-bl-2xl ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-14 items-center lg:grid-cols-12 lg:gap32">
                <div class="w-full xl:col-span-5 lg:col-span-6 block relative">
                    <div class="w-full sm:w-auto lg:w-96 xl:mr-16">
                        <img src="{{ $bgImg }}" alt="About Background Image"
                            class="rounded-lg object-cover w-full lg:h-auto">
                    </div>
                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2">
                        <img src="{{ $frontImg }}" alt="About Front"
                            class="rounded-lg object-cover h-52 w-52 lg:w-64 lg:h-64">
                    </div>
                </div>
                <div class="w-full xl:col-span-7 lg:col-span-6 2xl:mx-5 xl:mx-0">
                    <div class="flex items-center text-sm font-medium text-gray-500 justify-center lg:justify-start">
                        <span class="bg-defaultGreen py-1 px-3 rounded-2xl text-xs font-medium text-white mr-3 ">
                            #1
                        </span>
                        Restaurant
                    </div>
                    <h1
                        class="py-8 text-center text-defaultBlue font-bold font-manrope text-5xl lg:text-left leading-[70px]">
                        {{ $title }}
                    </h1>

                    <div class="text-gray-500 text-lg text-center lg:text-left mb-5 prose dark:prose-invert">
                        {!! $description !!}
                    </div>
                    <div class="text-left my-10">
                        <x-primary-button>
                            <x-heroicon-m-list-bullet class="mr-1 h-5 w-5" />
                            View Menu
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
