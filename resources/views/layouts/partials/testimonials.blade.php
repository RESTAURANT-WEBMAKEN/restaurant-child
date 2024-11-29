@props(['testimonials'])

@if ($testimonials)
    <section class="lg:py-20 h-full bg-indigo-50" id="testinomials">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 my-5">
            <div class="mb-16 ">
                <span class="text-sm text-defaultBlue font-medium text-center block mb-2">
                    What our happy user says!
                </span>
                <h2 class="text-4xl text-center font-bold text-gray-900 ">
                    Reviews
                </h2>
            </div>
            <!--Slider wrapper-->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-center items-center gap-8 swiper mySwiper">
                @forelse ($testimonials as $testimonial)
                    <x-testimonial name="{{ $testimonial['name'] }}"
                        review="{{ limit_str($testimonial['review'], 70) }}" />
                @empty
                @endforelse
            </div>
        </div>
    </section>
@endif
