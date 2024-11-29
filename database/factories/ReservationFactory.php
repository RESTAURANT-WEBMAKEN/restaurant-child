<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'persons' => $this->faker->numberBetween(1, 10),
            'comments' => $this->faker->sentence,
            // 'order_column' => $this->faker->numberBetween(1, 100), // Auto generate by Sortable trait
        ];

    }
}
