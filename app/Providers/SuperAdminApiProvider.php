<?php

namespace App\Providers;

use App\Exceptions\ApiDataException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SuperAdminApiProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Skip execution if running during composer install
        if ($this->isComposerInstall()) {
            return;
        }

        // Ensure the API data exists and cache it if it does
        $apiData = $this->fetchApiData();

        // Cache the data for 1 minute
        Cache::put('super_admin_api_data', $apiData, 60);

        // Share the data globally in all views
        View::share('superAdminApiData', $apiData);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register services if needed
    }

    /**
     * Check if the application is running during the Composer install process.
     * During composer install, App::runningInConsole() will return true.
     *
     * @return bool
     */
    private function isComposerInstall()
    {
        // If running in console mode, we're in `composer install`
        return App::runningInConsole();
    }

    /**
     * Fetch the API data and return it as an object (recursively).
     *
     * @return object
     * @throws ApiDataException
     */
    private function fetchApiData()
    {
        $baseUrl = config('app.api_url');
        $appUrl = config('app.restaurant_url');

        // Make the API request and get the response as an array
        $response = Http::get("{$baseUrl}/api/v1/settings/{$appUrl}");

        // Convert the JSON response to an array
        $apiData = $response->json();

        // Check if the API request was successful and contains data
        if ($response->successful() && $response->json()) {
            return (object) $apiData;
            // Recursively convert array to object
            // return $this->convertArrayToObject($apiData);
        }

        // If data doesn't exist or the request failed, throw an exception
        throw new ApiDataException('API data not found or failed to fetch data.');
    }

    /**
     * Recursively convert arrays to objects.
     *
     * @param mixed $array
     * @return object
     */
    private function convertArrayToObject($array)
    {
        if (is_array($array)) {
            return (object) array_map([$this, 'convertArrayToObject'], $array);
        }
        return $array;
    }
}
