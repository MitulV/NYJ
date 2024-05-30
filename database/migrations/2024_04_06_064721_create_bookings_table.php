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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->string('reference_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->dateTime('booking_date_time');
            $table->boolean('is_offline')->default(true);
            $table->string('payment_mode')->nullable();
            $table->boolean('checked_in')->default(false);
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
