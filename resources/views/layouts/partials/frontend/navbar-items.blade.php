@props(['metadata'])

<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#about-us">About Us</a>
</li>
@if ($metadata['reviews_page_status'])
    <li class="nav-item">
        <a class="nav-link" href="#reviews">Reviews</a>
    </li>
@endif
<li class="nav-item">
    <a class="nav-link" href="#contact">Contact Us</a>
</li>
@if ($metadata['reservation_page_status'])
    <li class="nav-item nav_buts">
        <a class="nav-link" href="{{ url('reservation.php') }}">Reservation</a>
    </li>
@endif
@if ($metadata['restaurant_menu_page_status'])
    <li class="nav-item nav_buts">
        <a class="nav-link" href="{{ url('restaurant-menu.php') }}">Restaurant Menu</a>
    </li>
@endif
@if ($metadata['takeaway_menu_page_status'])
    <li class="nav-item nav_buts">
        <a class="nav-link" href="{{ url('takeaway-menu.php') }}">Takeaway Menu</a>
    </li>
@endif
@if ($metadata['order_online_page_status'])
    <li class="nav-item nav_buts">
        <a class="nav-link" href="{{ url('order-online.php') }}">Order Online</a>
    </li>
@endif
<li class="nav-item sm_icons">
    @if ($socialMedia['instagram_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['instagram_link'] }}">
            <img src="{{ asset('assets/img/icons/instagram-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['facebook_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['facebook_link'] }}">
            <img src="{{ asset('assets/img/icons/facebook-square-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['tripadvisor_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['tripadvisor_link'] }}">
            <img src="{{ asset('assets/img/icons/tripadvisor-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['whatsapp_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['whatsapp_link_status'] }}">
            <img src="{{ asset('assets/img/icons/whatsapp-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['youtube_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['youtube_link'] }}">
            <img src="{{ asset('assets/img/icons/youtube-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['google_review_link_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['google_review_link'] }}">
            <img src="{{ asset('assets/img/icons/google-brands.svg') }}" alt="" class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['custom_link_1_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['custom_link_1_url'] }}">
            <img src="{{ $socialMedia['custom_link_1_img'] }}" alt=""
                class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['custom_link_2_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['custom_link_2_url'] }}">
            <img src="{{ $socialMedia['custom_link_2_img'] }}" alt=""
                class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['custom_link_3_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['custom_link_3_url'] }}">
            <img src="{{ $socialMedia['custom_link_3_img'] }}" alt=""
                class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['custom_link_4_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['custom_link_4_url'] }}">
            <img src="{{ $socialMedia['custom_link_4_img'] }}" alt=""
                class="sm_icons_css">
        </a>
    @endif
    @if ($socialMedia['custom_link_5_status'])
        <a class="nav-link sm_links" target="_blank" href="{{ $socialMedia['custom_link_5_url'] }}">
            <img src="{{ $socialMedia['custom_link_5_img'] }}" alt=""
                class="sm_icons_css">
        </a>
    @endif
</li>
