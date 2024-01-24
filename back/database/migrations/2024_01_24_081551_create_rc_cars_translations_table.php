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
        Schema::create('rc_cars_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->string('lang')->default('en');
            $table->string('title')->nullable();
            $table->string('page_title')->nullable();
            $table->string('page_meta_keywords')->nullable();
            $table->string('page_meta_description')->nullable();
            $table->text('description')->nullable();
            $table->string('footer_title')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_subtitle')->nullable();
            $table->text('footer_subdescription')->nullable();
            $table->string('attribute_color')->nullable();
            $table->string('attribute_interior_color')->nullable();
            $table->timestamps();
            $table->tinyInteger('was_migrated')->default(0);

            $table->foreign('car_id')->references('car_id')->on('rc_cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_cars_translations');
    }
};
