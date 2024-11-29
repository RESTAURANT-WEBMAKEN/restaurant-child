@props(['rollingMessage'])

@if (!empty($rollingMessage))
    <div class="overflow-hidden whitespace-nowrap h-10 bg-defaultBlue text-defaultWhite z-10">
        <marquee class="inline-block animation-marquee w-100">
            <p class="text-lg p-1">{{ $rollingMessage }}</p>
        </marquee>
    </div>
@endif
