<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\RollingMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RollingMessageFactory extends Factory
{
    protected $model = RollingMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            // 'restaurant_id' => Restaurant::factory(), // No need for now since we want only one restaurant
            'marquee_status' => $this->faker->boolean(),
            'active_marquee_no' => 2,
            'marquee_1' => $this->faker->sentence(),
            'marquee_2' => "Welcome to " . config('app.name') . " | You can change this rolling message from the admin panel if you are an admin.",
            'marquee_3' => $this->faker->sentence(),
            'holiday_marquee_status' => false,
            'holiday_marquee' => $this->faker->sentence(),
            'holiday_marquee_start_date' => $this->faker->date(),
            'holiday_marquee_start_time' => $this->faker->time(),
            'holiday_marquee_end_date' => $this->faker->date(),
            'holiday_marquee_end_time' => $this->faker->time(),
            'order_column' => $this->faker->numberBetween(1, 10),
            'updated_by_user_id' => User::factory(),
            'created_by_user_id' => User::factory(),
        ];
    }
}
