<x-app-layout :title="$data['name']">

    <x-slot name="rollingMessage">
        <x-layouts.rolling-message :$rollingMessage />
    </x-slot>

    @include('layouts.partials.hero-section', [
        'title' => $homePageData['header_section_title'],
        'description' => $homePageData['header_section_description'],
        'caption' => $homePageData['header_section_caption'],
        'bgImg' => $homePageData['header_section_background_img'],
    ])

    @include('layouts.partials.about-us', [
        'title' => $homePageData['about_section_title'],
        'description' => $homePageData['about_section_description'],
        'frontImg' => $homePageData['about_section_front_img'],
        'bgImg' => $homePageData['about_section_background_img'],
    ])

    @include('layouts.partials.center-section', [
        'title' => $homePageData['center_section_title'],
        'description' => $homePageData['center_section_description'],
        'caption' => $homePageData['center_section_caption'],
        'frontImg' => $homePageData['center_section_front_img'],
        'telephones' => $data['telephones'],
        'emails' => $data['emails'],
        'addresses' => $data['addresses'],
        'geo_location_link' => $data['geo_location_link'],
    ])

    @include('layouts.partials.testimonials', [
        'testimonials' => $testimonials,
    ])

    @include('layouts.partials.footer', [
        'telephones' => $data['telephones'],
        'emails' => $data['emails'],
        'addresses' => $data['addresses'],
        'geo_location_link' => $data['geo_location_link'],
    ])

</x-app-layout>
