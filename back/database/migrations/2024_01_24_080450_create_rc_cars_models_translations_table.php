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
        Schema::create('rc_cars_models_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_model_id');
            $table->string('lang')->default('en');
            $table->string('name')->nullable()->default(null);
            $table->string('page_title')->nullable()->default(null);
            $table->string('page_meta_keywords')->nullable()->default(null);
            $table->string('page_meta_description')->nullable()->default(null);
            $table->text('description');
            $table->string('footer_title')->nullable()->default(null);
            $table->text('footer_description');
            $table->string('footer_subtitle')->nullable()->default(null);
            $table->text('footer_subdescription');
            $table->timestamps();

            $table->foreign('car_model_id')->references('car_model_id')->on('rc_cars_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_cars_models_translations');
    }
};
