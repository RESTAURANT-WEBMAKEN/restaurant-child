@props(['colorTheme'])

<?php
// Group 1
$tc1 = $colorTheme?->theme_1;
$tc2 = $colorTheme?->theme_2;
$tc3 = $colorTheme?->theme_3;
$tc4 = $colorTheme?->theme_4;
$ltc1 = $colorTheme?->light_1;
$ltc2 = $colorTheme?->light_2;
$ltc3 = $colorTheme?->light_3;
$ltc4 = $colorTheme?->light_4;
$dtc1 = $colorTheme?->dark_1;
$dtc2 = $colorTheme?->dark_2;
$dtc3 = $colorTheme?->dark_3;
$dtc4 = $colorTheme?->dark_4;

// Group 2
$mtc1 = $colorTheme?->marquee_1;
$mtc2 = $colorTheme?->marquee_2;

// Group 3
$txtwhite = $colorTheme?->text_white;
$txtblack = $colorTheme?->text_black;

// Group 4
$backwhite = $colorTheme?->bg_white;
$backblack = $colorTheme?->bg_black;

// Group 5
$white = $colorTheme?->neutral_white;
$black = $colorTheme?->neutral_black;
$gray = $colorTheme?->neutral_gray;
$lgray = $colorTheme?->neutral_light_gray;
$elgray = $colorTheme?->neutral_x_light_gray;
$dgray = $colorTheme?->neutral_dark_gray;
?>

<style>
    :root {
        --white: {{ $white }};
        --black: {{ $black }};
        --gray: {{ $gray }};
        --lgray: {{ $lgray }};
        --elgray: {{ $elgray }};
        --dgray: {{ $dgray }};

        --tc_1: {{ $tc1 }};
        --tc_2: {{ $tc2 }};

        --ltc_1: {{ $ltc1 }};
        --ltc_2: {{ $ltc2 }};

        --mtc_1: #e6966b;
        --mtc_2: #8aad72;

        --dtc_1: {{ $dtc1 }};
        --dtc_2: {{ $dtc2 }};

        --m_color: #000;
        --m_back: #f0f0f0;
    }
</style>
