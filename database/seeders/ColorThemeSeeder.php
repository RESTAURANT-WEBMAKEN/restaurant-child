<?php

namespace Database\Seeders;

use App\Models\ColorTheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 2 color themes
        ColorTheme::factory()->count(2)->create();
    }
}
