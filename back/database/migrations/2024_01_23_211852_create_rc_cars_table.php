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
        Schema::create('rc_cars', function (Blueprint $table) {
            $table->id('car_id');
            $table->integer('car_model_id')->default(1);
            $table->integer('car_serie_id')->nullable()->default(null);
            $table->integer('car_body_id')->nullable()->default(null);
            $table->integer('company_id')->nullable()->default(null);
            $table->integer('city_id')->default(1);
            $table->unsignedInteger('sales_tax_id')->nullable()->default(null);
            $table->unsignedInteger('holiday_calculator_id')->nullable()->default(null);
            $table->unsignedInteger('range_calculator_id')->nullable()->default(null);
            $table->string('registration_number')->nullable()->default(null);
            $table->string('photo')->nullable()->default(null);
            $table->string('price_type')->default('luxury');
            $table->float('price_1')->unsigned()->default(0);
            $table->float('price_2')->default(0);
            $table->float('price_3_6')->default(0);
            $table->float('price_7_13')->default(0);
            $table->float('price_14_20')->default(0);
            $table->float('price_21_29')->default(0);
            $table->float('price_30_more')->default(0);
            $table->string('currency')->nullable()->default(null);
            $table->float('price_partner_1')->default(0);
            $table->float('price_partner_2')->default(0);
            $table->float('price_partner_3_6')->default(0);
            $table->float('price_partner_7_13')->default(0);
            $table->float('price_partner_14_20')->default(0);
            $table->float('price_partner_21_29')->default(0);
            $table->float('price_partner_30_more')->default(0);
            $table->integer('deposit')->nullable()->default(null);
            $table->float('overlimit_charge')->nullable()->default(null);
            $table->integer('salik')->default(5);
            $table->integer('age_restriction')->default(24);
            $table->integer('driving_licence_restriction')->nullable()->default(null);
            $table->tinyInteger('free_delivery_dubai')->default(1);
            $table->string('km_included_per_day')->nullable()->default(null);
            $table->string('km_included_per_month')->nullable()->default(null);
            $table->string('youtube_video_link')->nullable()->default(null);
            $table->integer('min_day_reservation')->nullable()->default(null);
            $table->string('attribute_year')->nullable()->default(null);
            $table->string('attribute_tinted')->nullable()->default(null);
            $table->string('attribute_max_speed')->nullable()->default(null);
            $table->string('attribute_0_100')->nullable()->default(null);
            $table->string('attribute_number_of_seats')->nullable()->default(null);
            $table->string('attribute_horsepower')->nullable()->default(null);
            $table->string('attribute_engine')->nullable()->default(null);
            $table->string('attribute_transmission')->nullable()->default(null);
            $table->string('attribute_mileage')->default('50,000');
            $table->integer('attribute_sm_bag')->default(1);
            $table->integer('attribute_lg_bag')->default(1);
            $table->integer('attribute_doors')->nullable()->default(null);
            $table->text('features');
            $table->integer('exterior_condition')->default(8);
            $table->integer('interior_condition')->default(8);
            $table->integer('engine_suspension_condition')->default(8);
            $table->string('insurance')->default('no');
            $table->integer('insurance_amount')->default(0);
            $table->text('insurance_default');
            $table->text('insurance_cdw')->nullable();
            $table->text('insurance_default_desc');
            $table->text('insurance_cdw_desc');
            $table->string('aiport_charge')->default('charge');
            $table->integer('complete')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('message_color')->nullable()->default(null);
            $table->string('message_title')->nullable()->default(null);
            $table->string('message_text')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('sort_time')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->tinyInteger('was_migrated')->default(0);
            $table->timestamp('was_migrated_at');
            $table->tinyInteger('from_carsss')->default(0);
            $table->tinyInteger('no_deposit_needed')->default(0);
            $table->integer('attribute_engine_type')->default(1);
            $table->tinyInteger('with_owner');
            $table->tinyInteger('in_abu_dhabi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_cars');
    }
};
