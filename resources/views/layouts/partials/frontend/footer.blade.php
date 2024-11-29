<?php

$active_items = 2; // Start with 2 because HOME and CONTACT are always present

if ($metadata['reservation_page_status']) {
    $active_items++;
}
if ($metadata['restaurant_menu_page_status']) {
    $active_items++;
}
if ($metadata['takeaway_menu_page_status']) {
    $active_items++;
}
if ($metadata['order_online_page_status']) {
    $active_items++;
}
?>
<div class="footer displayinmobile">
    <div class="footer_menu_grid columns-{{ $active_items }}">
        <div class="fmg_items">
            <a class="fmg_links color-white h-color-white nodec" href="{{ url('/') }}">
                <i class="fa-thin fa-house"></i>HOME
            </a>
        </div>
        <div class="fmg_items">
            <a class="fmg_links color-white h-color-white nodec" href="#contact">
                <i class="fa-thin fa-address-book"></i>CONTACT
            </a>
        </div>
        @if ($metadata['reservation_page_status'])
            <div class="fmg_items">
                <a class="fmg_links color-white h-color-white nodec" href="{{ url('reservation.php') }}">
                    <i class="fa-thin fa-calendar"></i>RESERVE
                </a>
            </div>
        @endif
        @if ($metadata['restaurant_menu_page_status'])
            <div class="fmg_items">
                <a class="fmg_links color-white h-color-white nodec" href="{{ url('restaurant-menu.php') }}">
                    <i class="fa-thin fa-list"></i>RESTAURANT</a>
            </div>
        @endif
        @if ($metadata['takeaway_menu_page_status'])
            <div class="fmg_items">
                <a class="fmg_links color-white h-color-white nodec" href="{{ url('takeaway-menu.php') }}">
                    <i class="fa-thin fa-list"></i>TAKEAWAY
                </a>
            </div>
        @endif
        @if ($metadata['order_online_page_status'])
            <div class="fmg_items">
                <a class="fmg_links color-white h-color-white nodec" href="{{ url('order-online.php') }}">
                    <i class="fa-thin fa-list"></i>ORDER ONLINE
                </a>
            </div>
        @endif
        <!-- <div class="fmg_items"><a class="fmg_links color-white h-color-white nodec" href="{{ url('/') }}order-online.php"><i class="fa-thin fa-list"></i>ORDER ONLINE</a></div> -->
    </div>
</div>
<style>
    .footer_menu_grid.columns-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .footer_menu_grid.columns-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .footer_menu_grid.columns-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .footer_menu_grid.columns-5 {
        grid-template-columns: repeat(5, 1fr);
    }

    .footer_menu_grid.columns-6 {
        grid-template-columns: repeat(6, 1fr);
    }
</style>
<footer class="back-tc1">
    <div class="footer_css paddingten">
        <div class="container">
            <div class="text-center">
                <p class="footer_p_css fontexsmall nomargin color-white">
                    Copyright © {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</footer>
