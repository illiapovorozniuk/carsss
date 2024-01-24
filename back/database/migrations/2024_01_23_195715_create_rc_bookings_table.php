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
        Schema::create('rc_bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->bigInteger('uid')->nullable()->default(null);
            $table->integer('car_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('added_by')->nullable()->default(null);
            $table->integer('company_id')->nullable()->default(null);
            $table->enum('source', ['agent','website','instagram','other','direct','carsss','sales','dwm','hourly','chauffeur','lpo','car-service']);
            $table->integer('agent_id')->nullable()->default(null);
            $table->integer('sales')->nullable()->default(null);
            $table->string('other')->nullable()->default(null);
            $table->enum('direct', ['whatsapp','website','instagram','facebook','referral'])->nullable()->default(null);
            $table->timestamp('start_date')->nullable()->default(null);
            $table->string('pickup_location')->nullable()->default(null);
            $table->string('pickup_place_id')->nullable()->default(null);
            $table->double('pickup_latitude')->nullable()->default(null);
            $table->double('pickup_longitude')->nullable()->default(null);
            $table->integer('pickup_driver')->nullable()->default(null);
            $table->string('pickup_driver_note')->nullable()->default('');
            $table->timestamp('end_date')->nullable()->default(null);
            $table->string('drop_location')->nullable()->default(null);
            $table->string('drop_place_id')->nullable()->default(null);
            $table->double('drop_latitude')->nullable()->default(null);
            $table->double('drop_longitude')->nullable()->default(null);
            $table->integer('drop_driver')->nullable()->default(null);
            $table->string('drop_driver_note')->nullable()->default('');
            $table->tinyInteger('send_sms_to_drivers')->nullable()->default(null);
            $table->tinyInteger('send_sms_to_me')->nullable()->default(null);
            $table->double('total_amount')->nullable()->default(null);
            $table->string('currency_id', 3)->nullable()->default(null);
            $table->integer('city_id')->default(1);
            $table->string('client_full_name')->nullable()->default(null);
            $table->string('special_request', 500)->nullable()->default(null);
            $table->integer('cancellation_answer_id')->nullable()->default(null);
            $table->text('cancellation_reason')->nullable();
            $table->tinyInteger('open_date')->default(0);
            $table->timestamp('paid_at')->nullable()->default(null);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('is_reserved')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('cancelled_by')->nullable()->default(null);
            $table->timestamp('cancelled_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('replacement')->default(0);
            $table->tinyInteger('is_agent')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_bookings');
    }
};
