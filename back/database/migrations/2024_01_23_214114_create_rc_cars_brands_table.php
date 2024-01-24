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
        Schema::create('rc_cars_brands', function (Blueprint $table) {
            $table->id('car_brand_id');
            $table->string('icon')->nullable()->default(null);
            $table->string('slug')->nullable()->default(null);
            $table->string('youtube_video_link')->nullable()->default(null);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_car_brands');
    }
};
