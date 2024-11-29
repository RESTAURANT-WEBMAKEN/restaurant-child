<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\Restaurant;
use App\Models\RollingMessage;
use Illuminate\Support\Facades\Cache;
use stdClass;

class RestaurantService
{
    public function getApiData($key = 'all')
    {
        // Retrieve the cached API data
        $apiData = Cache::get('super_admin_api_data');
        return $key == 'all' ? $apiData : $apiData?->$key ?? null;
    }
    public function getRestaurantData($domain = null): ?Restaurant
    {
        $domain ??= $this->getApiData('domain');
        $data = Restaurant::where('domain', $domain)->first();

        return $data;
    }

    public function getRollingMessage(): ?string
    {
        $rollingMsgData = RollingMessage::first();

        if ($rollingMsgData) {
            // Check for holiday message
            if ($this->isValidHoliday($rollingMsgData)) {
                return $rollingMsgData?->holiday_marquee;
            }

            // Check for regular message
            if ($rollingMsgData?->marquee_status && $rollingMsgData?->active_marquee_no > 0) {
                $marqueeColName = "marquee_{$rollingMsgData->active_marquee_no}";
                return $rollingMsgData?->$marqueeColName;
            }
        }

        return null;
    }

    public function getTestimonialsData(?Restaurant $data = null): ?array
    {
        $testimonialData = !empty($data->testimonials) && !empty($data->testimonials[0]) && !empty($data->testimonials[0]['status']) && !empty($data->testimonials[0]['reviews']) && count($data->testimonials[0]['reviews']);

        if ($testimonialData) {
            return $data['testimonials'][0]['reviews'];
        } else {
            return [];
        }
    }

    public function checkIsRestaurantClose(stdClass $apiData, ?Restaurant $restaurantData = null)
    {
        $appName = $restaurantData?->name ?? $apiData->name ?? config('app.name');

        $statusApi = $apiData->status ?? false;
        $statusRestaurant = $restaurantData?->status ?? false;

        $statusMsgApi = $apiData->status_msg ?? '';
        $statusMsgRestaurant = $restaurantData?->status_msg ?? '';

        return (object) [
            'name' => $appName,
            'status' => $statusApi || $statusRestaurant,
            'message' => $statusApi ? $statusMsgApi : $statusMsgRestaurant,
        ];
    }

    private function isValidHoliday(RollingMessage $data): bool
    {
        $holidayStatus = $data?->holiday_marquee_status;
        $startDatetime = $data?->start_datetime;
        $endDatetime = $data?->end_datetime;

        return $holidayStatus && $startDatetime && $endDatetime &&
        is_current_time_between($startDatetime, $endDatetime);
    }

    public function getMetaDataDetails(?Restaurant $data = null): ?array
    {
        $data = !empty($data->meta_details) ? $data->meta_details[0] : [];
        return [
            "main_page_status" => $data['main_page_status'] ?? false,
            "main_page_title" => $data['main_page_title'] ?? null,
            "main_page_description" => $data['main_page_description'] ?? null,
            "main_page_keywords" => $data['main_page_keywords'] ?? "",

            "reviews_page_status" => $data['reviews_page_status'] ?? false,
            "reviews_page_title" => $data['reviews_page_title'] ?? null,
            "reviews_page_description" => $data['reviews_page_description'] ?? null,
            "reviews_page_keywords" => $data['reviews_page_keywords'] ?? "",

            "reservation_page_status" => $data['reservation_page_status'] ?? false,
            "reservation_page_title" => $data['reservation_page_title'] ?? null,
            "reservation_page_description" => $data['reservation_page_description'] ?? null,
            "reservation_page_keywords" => $data['reservation_page_keywords'] ?? "",

            "restaurant_menu_page_status" => $data['restaurant_menu_page_status'] ?? false,
            "restaurant_menu_page_title" => $data['restaurant_menu_page_title'] ?? null,
            "restaurant_menu_page_description" => $data['restaurant_menu_page_description'] ?? null,
            "restaurant_menu_page_keywords" => $data['restaurant_menu_page_keywords'] ?? "",

            "takeaway_menu_page_status" => $data['takeaway_menu_page_status'] ?? false,
            "takeaway_menu_page_keywords" => $data['takeaway_menu_page_keywords'] ?? "",
            "takeaway_menu_page_title" => $data['takeaway_menu_page_title'] ?? null,
            "takeaway_menu_page_description" => $data['takeaway_menu_page_description'] ?? null,

            "order_online_page_status" => $data['order_online_page_status'] ?? false,
            "order_online_page_keywords" => $data['order_online_page_keywords'] ?? "",
            "order_online_page_title" => $data['order_online_page_title'] ?? null,
            "order_online_page_description" => $data['order_online_page_description'] ?? null,
        ];
    }

    public function getSocialMediaDetails(?Restaurant $data = null): ?array
    {
        $sm = !empty($data->social_links) ? $data->social_links[0] : [];
        $customSm = !empty($data->custom_social_links) ? $data->custom_social_links[0] : [];
        return [
            "status" => $sm['status'] ?? false, // Whole Show/Hide

            "instagram_link_status" => $sm['instagram_link_status'] ?? false,
            "instagram_link" => $sm['instagram_link'] ?? null,

            "facebook_link_status" => $sm['facebook_link_status'] ?? false,
            "facebook_link" => $sm['facebook_link'] ?? null,

            "tripadvisor_link_status" => $sm['tripadvisor_link_status'] ?? false,
            "tripadvisor_link" => $sm['tripadvisor_link'] ?? null,

            "whatsapp_link_status" => $sm['whatsapp_link_status'] ?? false,
            "whatsapp_link" => $sm['whatsapp_link'] ?? null,

            "youtube_link_status" => $sm['youtube_link_status'] ?? false,
            "youtube_link" => $sm['youtube_link'] ?? null,

            "google_review_link_status" => $sm['google_review_link_status'] ?? false,
            "google_review_link" => $sm['google_review_link'] ?? null,

            "custom_link_1_status" => $customSm['custom_link_1_status'] ?? false,
            "custom_link_1_url" => $customSm['custom_link_1_url'] ?? null,
            "custom_link_1_img" => Helpers::get_img_full_url('custom_social_links', $customSm['custom_link_1_img'] ?? null, 'public'),

            "custom_link_2_status" => $customSm['custom_link_2_status'] ?? false,
            "custom_link_2_url" => $customSm['custom_link_2_url'] ?? null,
            "custom_link_2_img" => Helpers::get_img_full_url('custom_social_links', $customSm['custom_link_2_img'] ?? null, 'public'),

            "custom_link_3_status" => $customSm['custom_link_3_status'] ?? false,
            "custom_link_3_url" => $customSm['custom_link_3_url'] ?? null,
            "custom_link_3_img" => Helpers::get_img_full_url('custom_social_links', $customSm['custom_link_3_img'] ?? null, 'public'),

            "custom_link_4_status" => $customSm['custom_link_4_status'] ?? false,
            "custom_link_4_url" => $customSm['custom_link_4_url'] ?? null,
            "custom_link_4_img" => Helpers::get_img_full_url('custom_social_links', $customSm['custom_link_4_img'] ?? null, 'public'),

            "custom_link_5_status" => $customSm['custom_link_5_status'] ?? "0",
            "custom_link_5_img" => $customSm['custom_link_5_img'] ?? null,
            "custom_link_5_url" => Helpers::get_img_full_url('custom_social_links', $customSm['custom_link_5_url'] ?? null, 'public'),
        ];
    }
}
