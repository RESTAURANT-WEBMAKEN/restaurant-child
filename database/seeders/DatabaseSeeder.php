<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Restaurant Admin',
            'email' => 'super-admin@menuempire.com',
            'role' => UserRoleEnum::ADMIN->value,
            'address' => 'Mumbai, India',
            'password' => 'Rakesh@123',
        ]);

        User::factory()->create([
            'name' => 'Shubham Raj',
            'email' => 'shubhambth0000@gmail.com',
            'role' => UserRoleEnum::ADMIN->value,
            'address' => 'Hariwatika Chowk, Bettiah, Bihar, India - 845438',
            'password' => 'Shubham@123',
        ]);

        $this->call(PageEditSeeder::class);
        // $this->call(RestaurantSeeder::class);
        $this->call(ColorThemeSeeder::class);
        $this->call(RollingMessageSeeder::class);

        // $this->call(RestaurantSeeder::class);

    }
}
