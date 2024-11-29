<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $domain_url;
global $website_name;
global $meta_keywords;
global $meta_description;
global $page_url;
global $meta_image;

$gmap = env('GOOGLE_MAP_URL');

$domain_url = url('/');
$website_name = config('app.name');
$meta_keywords = 'Restaurant in Antwerp, Antwerpen Restaurant, Indian Restaurant in Antwerp';
$meta_description = 'Restaurant in Antwerp, Antwerpen Restaurant, Indian Restaurant in Antwerp';
$page_url = url(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']));
$meta_image = asset('assets/img/logos/logo.jpg');
?>


<!-- CLEAR CACHE -->
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="pragma" content="no-cache" />

<!-- REQUIRED METAS -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title', $website_name)</title>
<meta content="@yield('meta_description', $meta_description)" name="description">
<meta content="@yield('meta_keywords', $meta_keywords)" name="keywords">

<!-- GOOGLE FONTS API -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Andada+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Semi+Condensed:ital,wght@0,1..1000;1,1..1000&display=swap"
    rel="stylesheet">

<!-- FAVICONS -->
<link href="{{ asset('assets/img/favicon/favicon.png') }}" rel="icon">
<link href="{{ asset('assets/img/favicon/favicon.png') }}" rel="apple-touch-icon">

<!-- OWL CAROUSEL CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
    integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css"
    integrity="sha512-C8Movfk6DU/H5PzarG0+Dv9MA9IZzvmQpO/3cIlGIflmtY3vIud07myMu4M/NTPJl8jmZtt/4mC9bAioMZBBdA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- FONTAWESOME CDN -->
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">

<!-- BOOTSTRAP CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<!-- DATA TABLES CDN -->
<link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css" rel="stylesheet">

<!-- MAIN STYLESHEET FILE -->
<link href="{{ asset('frontend/css/webmaken.css?v=' . date('YmdHis')) }}" rel="stylesheet">
<link href="{{ asset('frontend/css/style.css?v=' . date('YmdHis')) }}" rel="stylesheet">

<!-- WHATSAPP, FACEBOOK & TWITTER META -->
<meta property="og:site_name" content="<?= $website_name ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $page_url ?>">
<meta property="og:title" content="@yield('title', 'Menuempire')">
<meta property="og:description" content="@yield('meta_description', $meta_description)">
<meta property="og:image" content="@yield('meta_image', $meta_image)">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?= $page_url ?>">
<meta property="twitter:title" content="@yield('title', 'Menuempire')">
<meta property="twitter:description" content="@yield('meta_description', $meta_description)">
<meta property="twitter:image" content="@yield('meta_image', $meta_image)">

<!-- CANONICAL URL -->
<link rel="canonical" href="<?= $page_url ?>" />

<!-- Include datepicker.js library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
