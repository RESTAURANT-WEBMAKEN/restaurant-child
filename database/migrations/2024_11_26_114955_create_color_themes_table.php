<?php

use App\Enums\ColorThemeTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('color_themes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('restaurant_id')->nullable()->constrained('restaurants')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('name');

            // ------------------- Group 1: Theme Colors ----------------------
            // Warm, appetizing, and energetic colors for themes
            $table->string('theme_1')->default('#FF6F00'); // Warm orange (hunger, excitement)
            $table->string('theme_2')->default('#C62828'); // Deep red (appetite, energy)
            $table->string('theme_3')->default('#4CAF50'); // Fresh green (natural, healthy)
            $table->string('theme_4')->default('#FFD600'); // Bright yellow (optimism, happiness)

            // Lighter shades for light themes
            $table->string('light_1')->default('#FFAB40'); // Light orange
            $table->string('light_2')->default('#FF8A80'); // Light red
            $table->string('light_3')->default('#81C784'); // Light green
            $table->string('light_4')->default('#FFF59D'); // Light yellow

            // Darker shades for dark themes
            $table->string('dark_1')->default('#E65100'); // Dark orange
            $table->string('dark_2')->default('#B71C1C'); // Dark red
            $table->string('dark_3')->default('#388E3C'); // Dark green
            $table->string('dark_4')->default('#F9A825'); // Dark yellow

            // ------------------- Group 2: Marquee Colors ----------------------
            // Vibrant, bold colors to grab attention
            $table->string('marquee_1')->default('#D81B60'); // Bright pink (playful, bold)
            $table->string('marquee_2')->default('#8E24AA'); // Rich purple (luxury, creativity)

            // ------------------- Group 3: Text Colors ----------------------
            // Contrasting colors for text readability
            $table->string('text_white')->default('#FFFFFF'); // Pure white (clarity, simplicity)
            $table->string('text_black')->default('#000000'); // Deep black (formal, strong)

            // ------------------- Group 4: Background Colors ----------------------
            // Neutral and clean colors for backgrounds
            $table->string('bg_white')->default('#FFFFFF'); // Clean white (openness)
            $table->string('bg_black')->default('#212121'); // Soft black (modern, professional)

            // ------------------- Group 5: Neutral Colors ----------------------
            // Subtle, neutral tones for UI elements
            $table->string('neutral_white')->default('#FFFFFF'); // Clean white
            $table->string('neutral_black')->default('#000000'); // Deep black
            $table->string('neutral_gray')->default('#9E9E9E'); // Neutral gray (balance)
            $table->string('neutral_light_gray')->default('#F5F5F5'); // Light gray (soft, subtle)
            $table->string('neutral_x_light_gray')->default('#FAFAFA'); // Extra light gray
            $table->string('neutral_dark_gray')->default('#616161'); // Dark gray (modern, grounded)

            $table->string('active')->default(true);
            $table->tinyInteger('type')->default(ColorThemeTypeEnum::default()->value);

            $table->unsignedSmallInteger('order_column')->nullable();

            $table->foreignUuid('updated_by_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignUuid('created_by_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_themes');
    }
};
