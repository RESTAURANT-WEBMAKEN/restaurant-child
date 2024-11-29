<?php

namespace Database\Factories;

use App\Enums\ColorThemeTypeEnum;
use App\Models\ColorTheme;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ColorTheme>
 */
class ColorThemeFactory extends Factory
{
    protected $model = ColorTheme::class;

    protected static $active = true;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $isActive = static::$active;
        static::$active = false;

        return [
            // 'restaurant_id' => Restaurant::factory(), // No need for now since we want only one restaurant
            'name' => $this->faker->randomElement([
                'Default Theme 1',
                'Default Theme 2',
            ]),
            'theme_1' => $this->faker->hexColor(),
            'theme_2' => $this->faker->hexColor(),
            'theme_3' => $this->faker->hexColor(),
            'theme_4' => $this->faker->hexColor(),
            'light_1' => $this->faker->hexColor(),
            'light_2' => $this->faker->hexColor(),
            'light_3' => $this->faker->hexColor(),
            'light_4' => $this->faker->hexColor(),
            'dark_1' => $this->faker->hexColor(),
            'dark_2' => $this->faker->hexColor(),
            'dark_3' => $this->faker->hexColor(),
            'dark_4' => $this->faker->hexColor(),
            'marquee_1' => $this->faker->hexColor(),
            'marquee_2' => $this->faker->hexColor(),
            'text_white' => '#FFFFFF',
            'text_black' => '#000000',
            'bg_white' => '#FFFFFF',
            'bg_black' => '#212121',
            'neutral_white' => '#FFFFFF',
            'neutral_black' => '#000000',
            'neutral_gray' => '#9E9E9E',
            'neutral_light_gray' => '#F5F5F5',
            'neutral_x_light_gray' => '#FAFAFA',
            'neutral_dark_gray' => '#616161',
            'active' => $isActive,
            'type' => ColorThemeTypeEnum::DEFAULT,
            // 'order_column' => $this->faker->numberBetween(1, 100), // Will auto generate by sortable trait
            'created_by_user_id' => User::factory(), // Create or associate a user
            'updated_by_user_id' => User::factory(), // Create or associate a user
        ];

    }
}
