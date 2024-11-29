<?php

namespace App\CentralLogics;

use App\Http\Controllers\RestaurantController;
use App\Services\RestaurantService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function get_img_full_url($path, $data, $disk, $placeholder = null)
    {
        $place_holders = [
            'default' => asset('assets/img/favicon/favicon.png'),
            'logo' => asset('assets/img/logos/logo.png'),
            'favicon' => asset('assets/img/favicon/favicon.png'),
            'header_section_background_img' => asset('assets/img/page/header_section_background_img.jpg'),
            'about_section_front_img' => asset('assets/img/page/about_section_front_img.jpg'),
            'about_section_background_img' => asset('assets/img/page/about_section_background_img.jpg'),
            'center_section_front_img' => asset('assets/img/page/center_section_front_img.jpg'),
        ];

        try {
            if ($data && $disk == 's3' && Storage::disk('s3')->exists($path . '/' . $data)) {
                return Storage::disk('s3')->url($path . '/' . $data);
            }
        } catch (\Exception $e) {
        }

        // Validate the URL format
        if ($data && filter_var($data, FILTER_VALIDATE_URL)) {
            return $data;
        }

        if ($data && Storage::disk('public')->exists($path . '/' . $data)) {
            return asset('storage') . '/' . $path . '/' . $data;
        }

        if (Request::is('api/*')) {
            return null;
        }

        if (isset($placeholder) && array_key_exists($placeholder, $place_holders)) {
            return $place_holders[$placeholder];
        } elseif (array_key_exists($path, $place_holders)) {
            return $place_holders[$path];
        } else {
            return empty($placeholder) ? null : $place_holders['default'];
        }
    }

    public static function getRestaurantOrApiData()
    {
        $restaurantService = new RestaurantService();
        return $restaurantService->getRestaurantData() ?? $restaurantService->getApiData();
    }

    public static function appName(){
        $restaurantData = self::getRestaurantOrApiData();
        return $restaurantData['name'] ?? config('app.name');
    }
    public static function appFavicon(){
        $restaurantData = self::getRestaurantOrApiData();
        return Helpers::get_img_full_url(null, $restaurantData['favicon_full_url'] ?? null, 'public', 'favicon');
    }
    public static function appLogo(){
        $restaurantData = self::getRestaurantOrApiData();
        return Helpers::get_img_full_url(null, $restaurantData['favicon_logo_url'] ?? null, 'public', 'logo');
    }
}
