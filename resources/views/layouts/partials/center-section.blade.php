@props([
    'title',
    'description',
    'caption',
    'frontImg',
    'telephones' => [],
    'emails' => [],
    'addresses' => [],
    'geo_location_link' => null,
])

<section class="lg:pt-20 pt-0 h-full" id="center-section">
    <div class="rounded-2xl py-10 overflow-hidden m-5 lg:m-0 2xl:py-16 xl:py-8  lg:rounded-tl-2xl lg:rounded-bl-2xl ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-14 items-center lg:grid-cols-12 lg:gap32">
                <div class="w-full xl:col-span-5 lg:col-span-6 block">
                    <div class="w-full sm:w-auto lg:w-96 xl:mr-16">
                        <img src="{{ $frontImg }}" alt="Dashboard image"
                            class="rounded-lg object-cover w-full lg:h-auto">
                    </div>
                </div>
                <div class="w-full xl:col-span-7 lg:col-span-6 2xl:mx-5 xl:mx-0">
                    <h2 class="py-4 text-center text-defaultBlue font-bold font-manrope text-4xl leading-[50px]">
                        {{ $title }}
                    </h2>
                    <div class="text-gray-500 text-lg text-center lg:text-left mb-5 prose dark:prose-invert">
                        {!! $description !!}
                    </div>
                    <div class="h-0.5 bg-defaultBlue w-1/2 mx-auto"></div>
                    <h3 class="py-4 text-center text-defaultBlue font-bold font-manrope text-3xl leading-[70px]">
                        {{ $caption }}
                    </h3>
                    @if ($telephones || $emails || $addresses)
                        <div class="text-gray-500 text-lg text-center mb-5 prose dark:prose-invert">
                            <a href="{{ $geo_location_link ?? 'javascript:;' }}" class="hover:text-gray-900">
                                @foreach ($addresses as $address)
                                    <p>{{ $address }}</p>
                                @endforeach
                            </a>

                            @foreach ($telephones as $telephone)
                                <a href="tel:{{ $telephone }}" class="hover:text-gray-900">
                                    <p>{{ $telephone }}</p>
                                </a>
                            @endforeach

                            @foreach ($emails as $email)
                                <a href="mailto:{{ $email }}" class="hover:text-gray-900">
                                    <p>{{ $email }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <div class="text-center my-5">
                        <x-primary-button>
                            <x-heroicon-m-calendar-days class="mr-1 h-5 w-5" />Reservation
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
