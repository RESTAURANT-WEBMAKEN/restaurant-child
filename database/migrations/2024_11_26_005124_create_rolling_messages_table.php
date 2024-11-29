<?php

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
        Schema::create('rolling_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('restaurant_id')->nullable()->constrained('restaurants')->cascadeOnUpdate()->cascadeOnDelete();

            $table->boolean('marquee_status')->default(false);
            $table->tinyInteger('active_marquee_no')->default(1);

            $table->string('marquee_1')->nullable();
            $table->string('marquee_2')->nullable();
            $table->string('marquee_3')->nullable();

            $table->boolean('holiday_marquee_status')->default(false);
            $table->string('holiday_marquee')->nullable();
            $table->date('holiday_marquee_start_date')->nullable();
            $table->time('holiday_marquee_start_time')->nullable();
            $table->date('holiday_marquee_end_date')->nullable();
            $table->time('holiday_marquee_end_time')->nullable();

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
        Schema::dropIfExists('rolling_messages');
    }
};
