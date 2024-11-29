<x-frontend-layout :$metadata :$socialMedia :$colorTheme :$homePageData>

    @push('styles')
        <style>
            .navbar {
                background-color: transparent;
                background: linear-gradient(138deg, #00000000 0%, #00000000 100%);
            }

            .header_gap {
                padding-bottom: 0px !important;
            }

            .header_box_grid_css {
                background-image: url("{{ $homePageData['header_section_background_img'] }}");
                background-repeat: no-repeat;
            }

            .footer_back {
                background-image: url("{{ asset('assets/img/page/footer_back.png') }}");
            }
        </style>
    @endpush

    {{-- Check $content Variable whats should in it & also $common_alt_title --}}
    @if ($rollingMessage)
        <x-slot name="rollingMessage">{{ $rollingMessage }}</x-slot>
    @endif

    <!--MAIN CONTENT START-->
    {{-- Hero Section --}}
    <div class="header_box_grid_css displayinpc">
        <div class="hb_overlay_css">
            <div class="hb_main_content_css">
                <h1 class="hb_title_css">{{ $homePageData['header_section_title'] }}</h1>
                <div class="hb_desc_css">{{ $homePageData['header_section_description'] }}</div>
                <div class="hb_buttons_grid">
                    @if ($metadata['reservation_page_status'])
                        <a href="{{ route('home') }}/reservation.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-calendar-days"></i> RESERVATION
                        </a>
                    @endif
                    @if ($metadata['restaurant_menu_page_status'])
                        <a href="{{ route('home') }}/restaurant-menu.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-list"></i> RESTAURANT MENU
                        </a>
                    @endif
                    @if ($metadata['takeaway_menu_page_status'])
                        <a href="{{ route('home') }}/takeaway-menu.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-list"></i> TAKEAWAY MENU
                        </a>
                    @endif
                    @if ($metadata['order_online_page_status'])
                        <a href="{{ route('home') }}/order-online.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-basket-shopping"></i> ORDER ONLINE
                        </a>
                    @endif
                </div>
                <p class="hb_caption_css">{{ $homePageData['header_section_caption'] }}</p>
            </div>
        </div>
    </div>

    {{-- Display on mobile Section --}}
    <div class="displayinmobile m_p_tb_30 header_m_box_css">
        <div class="main_contact_container">
            <div class="grid_contact_container">
                <div class="gcc_mid text-center">
                    <a href="{{ route('home') }}" class="nodec">
                        <img src="{{ asset('assets/img/logos/logo.png') }}" class="footer_logo_css"
                            alt="{{ config('app.name') }}">
                    </a>
                </div>
                <div class="gcc_end text-center">
                    @foreach ($data?->telephones ?? [] as $telephone)
                        <a href="tel:{{ $telephone }}" class="nodec color-black h-color-tc1 em_links_css">
                            <i class="fa-duotone fa-mobile fa-shake"></i> {{ $telephone }}
                        </a>
                    @endforeach
                    <br><br>
                    @foreach ($data?->emails ?? [] as $email)
                        <a href="mailto:{{ $email }}" class="nodec color-black h-color-tc1 em_links_css">
                            <i class="fa-duotone fa-envelope fa-flip"></i>{{ $email }}
                        </a>
                    @endforeach
                </div>
                <div class="hb_buttons_grid">
                    @if ($metadata['reservation_page_status'])
                        <a href="{{ route('home') }}/reservation.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-calendar-days"></i> RESERVATION
                        </a>
                    @endif
                    @if ($metadata['restaurant_menu_page_status'])
                        <a href="{{ route('home') }}/restaurant-menu.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-list"></i> RESTAURANT MENU
                        </a>
                    @endif
                    @if ($metadata['takeaway_menu_page_status'])
                        <a href="{{ route('home') }}/takeaway-menu.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-list"></i> TAKEAWAY MENU
                        </a>
                    @endif
                    @if ($metadata['order_online_page_status'])
                        <a href="{{ route('home') }}/order-online.php"
                            class="nodec res_buttons_css color-black h-color-tc1">
                            <i class="fa-duotone fa-basket-shopping"></i> ORDER ONLINE
                        </a>
                    @endif
                </div>
                <div class="sm_icons">
                    @if ($socialMedia['instagram_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['instagram_link'] }}">
                            <img src="{{ asset('assets/img/icons/instagram-brands.svg') }}" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                    @if ($socialMedia['facebook_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['facebook_link'] }}">
                            <img src="{{ asset('assets/img/icons/facebook-square-brands') }}.svg" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                    @if ($socialMedia['tripadvisor_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['tripadvisor_link'] }}">
                            <img src="{{ asset('assets/img/icons/tripadvisor-brands.svg') }}" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                    @if ($socialMedia['whatsapp_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['whatsapp_link_status'] }}">
                            <img src="{{ asset('assets/img/icons/whatsapp-brands.svg') }}" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                    @if ($socialMedia['youtube_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['youtube_link'] }}">
                            <img src="{{ asset('assets/img/icons/youtube-brands.svg') }}" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                    @if ($socialMedia['google_review_link_status'])
                        <a class="sm_links" target="_blank" href="{{ $socialMedia['google_review_link'] }}">
                            <img src="{{ asset('assets/img/icons/google-brands.svg') }}" alt=""
                                class="sm_icons_css">
                        </a>
                    @endif
                </div>
                <div class="gcc_end text-center">
                    <a class="nodec color-black h-color-tc1" target="_blank"
                        href="{{ $geo_location_link ?? 'javascript:;' }}">
                        <p class="cust-margin">
                            @foreach ($data?->addresses ?? [] as $address)
                                @if ($loop->index == 0)
                                    <i class="fa-solid fa-shop"></i><br>
                                @endif
                                <br>{{ $address }}
                            @endforeach
                        </p>
                    </a>
                </div>
                <div class="gcc_start text-center">
                    <p class="cust-margin">
                        @if (!empty($content))
                            <h2 class="sub_headings">Openingsuren</h2>
                            {{ $content }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- About Us Section --}}
    <div id="about-us" class="container d_m_tb_60 m_m_tb_40">
        <div class="about_details_grid d_m_t_10 m_m_t_10">
            <div class="adg_item_one">
                <img src="{{ $homePageData['about_section_background_img'] }}" class="adg_img_back"
                    alt="About back image">
                <img src="{{ $homePageData['about_section_front_img'] }}" class="adg_img_front"
                    alt="About front image">
            </div>
            <div class="adg_item_two">
                <h2 class="main_headings d_m_b_20 m_m_b_20">
                    {{ !empty($homePageData['about_section_title']) ? $homePageData['about_section_title'] : "Welcome to <div class='displayinmobile'></div>$website_name" }}
                </h2>
                <p class="adg_para">
                    {!! $homePageData['about_section_description'] !!}
                </p>
                <div class="line_grid_items d_m_t_40 m_m_t_15">
                    @if ($metadata['restaurant_menu_page_status'])
                        <a href="{{ route('home') }}/restaurant-menu.php"
                            class="nodec res_buttons_tc_css h-color-white">
                            <i class="fa-duotone fa-list"></i> VIEW MENU
                        </a>
                    @endif
                    @if ($metadata['takeaway_menu_page_status'])
                        <a href="{{ route('home') }}/takeaway-menu.php"
                            class="nodec res_buttons_tc_css h-color-white">
                            <i class="fa-duotone fa-list"></i> TAKEAWAY MENU
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <hr class="hr-class-fw">
    </div>

    {{-- Center Section --}}
    <div class="container d_m_tb_60 m_m_tb_40">
        <div class="about_details_grid d_m_t_10 m_m_t_10">
            <div class="cb_item_one">
                <img src="{{ $homePageData['center_section_front_img'] }}" class="cb_img" alt="Center Image">
            </div>
            <div class="cb_item_two">
                <h2 class="main_headings text-center d_m_b_20 m_m_b_20">
                    {{ $homePageData['center_section_title'] }}
                </h2>
                <p class="text-center">
                    {!! $homePageData['center_section_description'] !!}
                </p>
                <hr class="hr-class-hw">
                <h3 class="sub_headings d_m_tb_20 m_m_tb_20">
                    {{ $homePageData['center_section_caption'] }}
                </h3>
                <p class="cust-margin">
                    <a class="nodec color-black h-color-tc1" target="_blank"
                        href="{{ $geo_location_link ?? 'javascript:;' }}">
                        <p class="cust-margin text-center">
                            @foreach ($data?->addresses ?? [] as $address)
                                @if ($loop->index > 0)
                                    <br>
                                @endif
                                {{ $address }}
                            @endforeach
                        </p>
                    </a>
                    <br>
                    @foreach ($data?->telephones ?? [] as $telephone)
                        <a href="tel:{{ $telephone }}" class="nodec color-black h-color-tc1">
                            <i class="fa-duotone fa-mobile fa-shake"></i> {{ $telephone }}
                        </a>
                    @endforeach
                    <br>
                    @foreach ($data?->emails ?? [] as $email)
                        <a href="mailto:{{ $email }}" class="nodec color-black h-color-tc1">
                            <i class="fa-duotone fa-envelope fa-flip"></i>{{ $email }}
                        </a>
                    @endforeach
                </p>
                <div class="line_grid_items d_m_t_40 m_m_t_15">
                    @if ($metadata['reservation_page_status'])
                        <a href="{{ route('home') }}/reservation.php" class="nodec res_buttons_tc_css h-color-white">
                            <i class="fa-duotone fa-calendar-days"></i> RESERVATION
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Testimonial Section --}}
    @if (count($testimonials) > 0)
        <div id="reviews" class="review_main_border container-fluid d_m_tb_60 m_m_tb_40">
            <div class="container d_p_t_60 m_p_t_40 ">
                <h2 class="main_headings text-center">
                    REVIEWS
                </h2>
                <br>
                <hr class="hr_reser_css">
                <br>
                <div class="star_ratings d_m_t_15 m_m_t_15">
                    <div class="owl-carousel owl-theme" id="reviews_items_lists">
                        @foreach ($testimonials as $testimonial)
                            <div class="item clrev_item">
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span @class(['star', 'filled' => $i <= 5])></span>
                                    @endfor
                                </div>
                                <h5 class="reviewer color-black">{{ $testimonial['review'] }}</h5>

                                <p class="description">{{ $testimonial['name'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Contact Section --}}
    <div id="contact" class="footer_back">
        <div class="container-fluid d_p_tb_40 m_p_tb_30">
            <div class="container">
                <div class="main_contact_container">
                    <div class="grid_contact_container">
                        <div class="gcc_start text-center">
                            <p class="cust-margin">
                                @if (!empty($content))
                                    {{ $content }}
                                @endif
                            </p>
                        </div>
                        <div class="gcc_mid text-center">
                            <a href="{{ route('home') }}" class="nodec">
                                <img src="{{ asset('assets/img/logos/logo.png') }}" class="footer_logo_css"
                                    alt="{{ $common_alt_title ?? config('app.name') }}">
                            </a>
                        </div>

                        <div class="gcc_end text-center">
                            <a class="nodec color-black h-color-tc1" target="_blank"
                                href="{{ $geo_location_link ?? 'javascript:;' }}">
                                <p class="cust-margin">
                                    @foreach ($data?->addresses ?? [] as $address)
                                        @if ($loop->index == 0)
                                            <i class="fa-solid fa-shop"></i><br>
                                        @endif
                                        <br>{{ $address }}
                                    @endforeach
                                </p>
                            </a>
                            <br>
                            @foreach ($data?->telephones ?? [] as $telephone)
                                <a href="tel:{{ $telephone }}" class="nodec color-black h-color-tc1 em_links_css">
                                    <i class="fa-duotone fa-mobile fa-shake"></i> {{ $telephone }}
                                </a>
                            @endforeach
                            <br><br>
                            @foreach ($data?->emails ?? [] as $email)
                                <a href="mailto:{{ $email }}"
                                    class="nodec color-black h-color-tc1 em_links_css">
                                    <i class="fa-duotone fa-envelope fa-flip"></i>{{ $email }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MAIN CONTENT END-->

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const resMarquees = document.querySelector('.res_marquees_css');
                const navbar = document.querySelector('.navbar');

                function adjustMarqueeMargin() {
                    const resMarqueesHeight = resMarquees.offsetHeight;
                    if (window.scrollY === 0) {
                        navbar.style.marginTop = resMarqueesHeight + 'px';
                    } else {
                        navbar.style.marginTop = '0px';
                    }
                }

                function handleScroll() {
                    if (window.scrollY > 0) {
                        navbar.classList.add('nav_scrolled');
                        navbar.style.marginTop = '0px';
                    } else {
                        navbar.classList.remove('nav_scrolled');
                        adjustMarqueeMargin();
                    }
                }
                adjustMarqueeMargin();
                window.addEventListener('scroll', handleScroll);
                window.addEventListener('resize', adjustMarqueeMargin);
            });
        </script>
    @endpush

</x-frontend-layout>
