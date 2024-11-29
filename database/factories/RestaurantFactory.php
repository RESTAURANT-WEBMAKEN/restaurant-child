<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(), // Generate a UUID
            'name' => $this->faker->company, // Random company name
            'description' => $this->faker->paragraph, // Random paragraph
            'domain' => 'https://'.$this->faker->unique()->domainName, // Full domain URL
            'logo' => $this->faker->imageUrl(), // Random image URL
            'installation_token' => Str::random(40), // Random installation token
            'featured' => $this->faker->boolean,
            'visible' => $this->faker->boolean,
            'verified' => $this->faker->boolean,
            'status' => $this->faker->boolean,
            'status_msg' => $this->faker->sentence,
            'online_order_status' => $this->faker->boolean,
            'online_order_msg' => $this->faker->sentence,
            'reservation_status' => $this->faker->boolean,
            'reservation_msg' => $this->faker->sentence,
            'shutdown_status' => $this->faker->boolean,
            'shutdown_msg' => $this->faker->sentence,
            // 'order_column' => $this->faker->optional()->numberBetween(1, 100), // It'll be generated automatically by spatie/eloquent-sortable package
            'other_details' => $this->faker->optional()->randomElement([
                [['key' => 'key1', 'value' => 'value1']],
                [['key' => 'key2', 'value' => 'value2']],
            ]), // Optional JSON data
            'updated_by_user_id' => User::factory(), // Assuming you have a User model factory
            'created_by_user_id' => User::factory(),
        ];
    }
}
