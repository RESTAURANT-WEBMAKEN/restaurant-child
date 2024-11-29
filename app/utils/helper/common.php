<?php

use Carbon\Carbon;

if (!function_exists('clean_url')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $url
     * @return string
     */
    function clean_url($url)
    {
        return str_replace('//', '/', $url);
    }
}

if (!function_exists('asset')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $url
     * @return mixed
     */
    function asset($url)
    {
        $asset_url = env('ASSET_URL', env('APP_URL', './'));
        return clean_url("$asset_url/$url");
    }
}

if (!function_exists('url')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $url
     * @return mixed
     */
    function url($url)
    {
        $app_url = env('APP_URL', '/');
        return clean_url("$app_url/$url");
    }
}

if (!function_exists('now')) {
    /**
     * Get a new instance of Carbon for the current date and time.
     *
     * @return \Carbon\Carbon
     */
    function now()
    {
        return Carbon::now();
    }
}

if (!function_exists('today')) {
    /**
     * Get a new instance of Carbon for the current date.
     *
     * @return \Carbon\Carbon
     */
    function today()
    {
        return Carbon::today();
    }
}

if (!function_exists('customDate')) {
    /**
     * Get a new instance of Carbon for a custom date.
     *
     * @param string $date
     * @return \Carbon\Carbon
     */
    function customDate($date)
    {
        return Carbon::parse($date);
    }
}

if (!function_exists('currentTime')) {
    /**
     * Get a new instance of Carbon for the current time.
     *
     * @return \Carbon\Carbon
     */
    function currentTime()
    {
        return Carbon::now()->format('H:i:s');
    }
}

if (!function_exists('isCurrentDateTimeInRangeWithString')) {
    /**
     * Check if the current date and time is within the specified range.
     *
     * @param string $startDate
     * @param string $startTime
     * @param string $endDate
     * @param string $endTime
     * @return bool
     */
    function isCurrentDateTimeInRangeWithString($startDate, $startTime, $endDate, $endTime)
    {
        try {
            // Ensure that date and time strings are properly combined
            $startDateTimeString = $startDate . ' ' . $startTime;
            $endDateTimeString = $endDate . ' ' . $endTime;

            // Create Carbon instances
            $startDateTime = Carbon::parse($startDateTimeString);
            $endDateTime = Carbon::parse($endDateTimeString);
            $currentDateTime = Carbon::now();

            // Check if the current date and time is between the start and end date times
            return $currentDateTime->between($startDateTime, $endDateTime);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., invalid date/time format)
            return false;
        }
    }
}

if (!function_exists('isCurrentDateTimeInRange')) {
    /**
     * Check if the current date and time is within the specified range.
     *
     * @param Carbon $startDate
     * @param Carbon $startTime
     * @param Carbon $endDate
     * @param Carbon $endTime
     * @return bool
     */
    function isCurrentDateTimeInRange(Carbon $startDate, Carbon $startTime, Carbon $endDate, Carbon $endTime)
    {
        try {
            // Combine the start and end date with the respective times
            $startDateTime = $startDate->copy()->setTime($startTime->hour, $startTime->minute, $startTime->second);
            $endDateTime = $endDate->copy()->setTime($endTime->hour, $endTime->minute, $endTime->second);
            $currentDateTime = Carbon::now();

            // Check if the current date and time is between the start and end date times
            return $currentDateTime->between($startDateTime, $endDateTime);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., invalid date/time format)
            return false;
        }
    }
}

if (!function_exists('getDatesBetween')) {
    /**
     * Returns an array of dates between two DateTime objects, inclusive.
     *
     * @param DateTime|string $startDate Start date as a DateTime object or string in 'Y-m-d' format.
     * @param DateTime|string $endDate End date as a DateTime object or string in 'Y-m-d' format.
     * @return array An array of dates in 'Y-m-d' format, or an empty array if start date is after end date.
     */
    function getDatesBetween($startDate, $endDate)
    {
        // Convert to DateTime if they are strings
        if (is_string($startDate)) {
            $startDate = new DateTime($startDate);
        }
        if (is_string($endDate)) {
            $endDate = new DateTime($endDate);
        }

        // Check if input is valid DateTime objects
        if (!($startDate instanceof DateTime) || !($endDate instanceof DateTime)) {
            return [];
        }

        // Ensure $endDate is inclusive
        $endDate->modify('+1 day');

        // If start date is after end date, return empty array
        if ($startDate > $endDate) {
            return [];
        }

        // Initialize the array to hold dates
        $dates = [];

        // Create the DatePeriod
        $interval = new DateInterval('P1D'); // 1 day interval
        $period = new DatePeriod($startDate, $interval, $endDate);

        // Populate the dates array
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
}

if (!function_exists('generateTimeSlots')) {
    /**
     * Generate time slots between a start time and an end time with a given slot duration.
     *
     * @param string $startTimeStr Start time in "Y-m-d H:i" format.
     * @param Carbon|string $endTime End time as a Carbon instance or string.
     * @param int $slotDurationMinutes Duration of each slot in minutes.
     * @return array Array of slots with start and end times.
     * @throws InvalidArgumentException If end time is before start time.
     */
    function generateTimeSlots($startTimeStr, $endTime, $slotDurationMinutes)
    {
        // Convert startTimeStr to a Carbon instance
        $startTime = Carbon::parse($startTimeStr);

        // Ensure that endTime is a Carbon instance
        if (!$endTime instanceof Carbon) {
            $endTime = Carbon::parse($endTime);
        }

        // Ensure that endTime is after startTime
        if ($endTime <= $startTime) {
            // throw new InvalidArgumentException("End time must be after start time");
            return [];
        }

        // Generate time slots
        $slots = [];
        $currentTime = $startTime;

        while ($currentTime < $endTime) {
            $slotEndTime = $currentTime->copy()->addMinutes($slotDurationMinutes);
            if ($slotEndTime > $endTime) {
                break;
            }
            $slots[] = [
                'start' => $currentTime->format('h:i A'),
                'end' => $slotEndTime->format('h:i A')
            ];
            $currentTime = $slotEndTime; // Move to the next slot start time
        }

        return $slots;
    }
}

if (!function_exists('roundUpToNearestInterval')) {
    /**
     * Round up a time to the nearest interval.
     *
     * @param string $time The time to round (in H:i:s format).
     * @param int $interval The interval to round to (in minutes).
     * @return string The rounded time in H:i:s format.
     */
    function roundUpToNearestInterval($time, $interval)
    {
        // Convert time to total minutes from the start of the day
        $timestamp = strtotime($time);
        $hours = date('H', $timestamp);
        $minutes = date('i', $timestamp);

        $totalMinutes = ($hours * 60) + $minutes;
        $intervalMinutes = $interval;

        // Calculate the rounded minutes
        $roundedMinutes = ceil($totalMinutes / $intervalMinutes) * $intervalMinutes;

        // Convert rounded minutes back to hours and minutes
        $roundedHours = floor($roundedMinutes / 60);
        $roundedMinutes = $roundedMinutes % 60;

        // Format the result as H:i:s
        return sprintf('%02d:%02d:%02d', $roundedHours, $roundedMinutes, 0);
    }
}
