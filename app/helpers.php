<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

if (!function_exists('is_current_time_between')) {
    /**
     * Check if the current time is between the given start and end datetime.
     *
     * @param string $startDatetime
     * @param string $endDatetime
     * @return bool
     */
    function is_current_time_between($startDatetime, $endDatetime): bool
    {
        $currentTime = Carbon::now();

        // Ensure both startDatetime and endDatetime are Carbon instances
        $startDateTime = $startDatetime instanceof Carbon ? $startDatetime : Carbon::parse($startDatetime);
        $endDateTime = $endDatetime instanceof Carbon ? $endDatetime : Carbon::parse($endDatetime);

        return $currentTime->between($startDateTime, $endDateTime);
    }
}

if (!function_exists('update_env_value')) {
    function update_env_value($key, $value, $cache = true)
    {
        $envPath = base_path('.env');
        $oldValue = env($key); // Get the current value

        // Wrap the value in quotes if it contains spaces
        if (str_contains($value, ' ')) {
            $value = "\"{$value}\"";
        }

        if (file_exists($envPath)) {
            $fileContents = file_get_contents($envPath);
            $pattern = "/^{$key}=.*/m";

            // If the key exists in the .env file, update its value
            if (preg_match($pattern, $fileContents)) {
                $fileContents = preg_replace($pattern, "{$key}={$value}", $fileContents);
            } else {
                // If the key does not exist, append it
                $fileContents .= "\n{$key}={$value}\n";
            }

            file_put_contents($envPath, $fileContents);

            // Clear the config cache
            Artisan::call('config:clear');

            // Optionally rebuild the config cache
            if ($cache) {
                Artisan::call('config:cache');
            }

            return "Updated {$key} from '{$oldValue}' to '{$value}' successfully.";
        }

        return "Failed to update {$key}. .env file not found.";
    }
}

if (!function_exists('limit_str')) {
    /**
     * Limit the length of a string and append ellipses (...) if necessary.
     *
     * @param string $string The string to be limited.
     * @param int $limit The maximum length of the string.
     * @param string $end The string to append if the limit is exceeded (default: '...').
     * @return string The limited string.
     */
    function limit_str($string, $limit = 50, $end = '...')
    {
        if (mb_strlen($string) > $limit) {
            return mb_substr($string, 0, $limit) . $end;
        }

        return $string;
    }
}

if (!function_exists('invert_hex_color')) {
    /**
     * Invert a hex color code.
     *
     * @param string|null $hexColor The hex color code (e.g., "#FFFFFF" or "FFFFFF").
     * @return string|null The inverted hex color code (e.g., "#000000"), or null if input is invalid.
     */
    function invert_hex_color(?string $hexColor): ?string
    {
        if (!$hexColor) {
            return null;
        }

        $hexColor = ltrim($hexColor, '#');

        // Validate the hex color (either 3 or 6 characters)
        if (!preg_match('/^[a-fA-F0-9]{3}$|^[a-fA-F0-9]{6}$/', $hexColor)) {
            return null; // Return null for invalid input instead of throwing an exception
        }

        // Expand shorthand hex (e.g., "ABC" -> "AABBCC")
        if (strlen($hexColor) === 3) {
            $hexColor = preg_replace('/(.)/', '$1$1', $hexColor);
        }

        // Invert the color
        $r = 255 - hexdec(substr($hexColor, 0, 2));
        $g = 255 - hexdec(substr($hexColor, 2, 2));
        $b = 255 - hexdec(substr($hexColor, 4, 2));

        return sprintf("#%02X%02X%02X", $r, $g, $b);
    }
}


if (!function_exists('is_valid_hex_color')) {
    /**
     * Validate if a given value is a valid hex color.
     *
     * @param string|null $hexColor
     * @return bool
     */
    function is_valid_hex_color(?string $hexColor): bool
    {
        return preg_match('/^#?[a-fA-F0-9]{3}$|^#?[a-fA-F0-9]{6}$/', $hexColor);
    }
}

