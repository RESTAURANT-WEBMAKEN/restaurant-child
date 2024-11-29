<?php

namespace Database\Seeders;

use App\Models\PageEdit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageEditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageEdit::factory()->count(1)->create();
    }
}
