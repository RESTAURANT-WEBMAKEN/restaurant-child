<?php

namespace Database\Seeders;

use App\Models\RollingMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RollingMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RollingMessage::factory()->count(1)->create();
    }
}
