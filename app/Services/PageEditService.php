<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\PageEdit;

class PageEditService
{
    public static string $home_page_key = 'home_page';
    public function getHomePageData()
    {
        $appName = config('app.name');
        $homePageData = PageEdit::where(['key' => static::$home_page_key])?->first()?->value;

        // Generate array for home page dynmaic text and images
        return [
            'header_section_title' => $homePageData['header_section_title'] ?? "Welcome to the {$appName}",
            'header_section_description' => $homePageData['header_section_description'] ?? 'Ordering & Reservation possible from Telephone, Email, Reservation System',
            'header_section_caption' => $homePageData['header_section_caption'] ?? 'BEST RESTAURANT',
            'header_section_background_img' => Helpers::get_img_full_url('page_customization', $homePageData['header_section_background_img'] ?? null, 'public', 'header_section_background_img'),

            'about_section_title' => $homePageData['about_section_title'] ?? "About {$appName}",
            'about_section_description' => $homePageData['about_section_description'] ??

            "<p>'$appName' invites you on a culinary journey unlike any other in the heart of Antwerp. With a blend of tradition and innovation, our restaurant offers an unforgettable dining experience.</p><br>

            <p>Indulge in the artistry of Japanese cuisine with our main offerings of Teppanyaki and Sushi, meticulously prepared by our skilled chefs. From perfectly seared meats to delicate rolls of sushi, each dish is crafted with precision and passion.</p><br>

            <p>Join us at Nani Antwerp, where exceptional service meets exquisite cuisine, and let us elevate your dining experience to new heights.</p>",

            'about_section_front_img' =>  Helpers::get_img_full_url('page_customization', $homePageData['about_section_front_img'] ?? null, 'public', 'about_section_front_img'),
            'about_section_background_img' => Helpers::get_img_full_url('page_customization', $homePageData['about_section_background_img'] ?? null, 'public', 'about_section_background_img'),

            'center_section_title' => $homePageData['center_section_title'] ?? "Book a Table",
            'center_section_description' => $homePageData['center_section_description'] ?? "Fill up your informations in the Reservation Form and get you reservation confirmation through Mail.",
            'center_section_caption' => $homePageData['center_section_caption'] ?? $appName,
            'center_section_front_img' => Helpers::get_img_full_url('page_customization', $homePageData['center_section_front_img'] ?? null, 'public', 'center_section_front_img'),
        ];
    }
}
