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
        Schema::create('rc_cars_models', function (Blueprint $table) {
            $table->id('car_model_id');
            $table->integer('car_brand_id')->nullable()->default(null);
            $table->integer('car_body_id');
            $table->string('slug')->nullable()->default(null);
            $table->string('type')->default('luxury');
            $table->string('attribute_0_100')->nullable()->default(null);
            $table->string('attribute_max_speed')->nullable()->default(null);
            $table->string('attribute_number_of_seats')->nullable()->default(null);
            $table->string('attribute_horsepower')->nullable()->default(null);
            $table->string('attribute_engine')->nullable()->default(null);
            $table->string('attribute_transmission')->nullable()->default(null);
            $table->string('attribute_interior_color')->nullable()->default(null);
            $table->integer('attribute_doors')->default(4);
            $table->text('features');
            $table->string('youtube_video_link')->nullable()->default(null);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('attribute_engine_type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_cars_models');
    }
};
