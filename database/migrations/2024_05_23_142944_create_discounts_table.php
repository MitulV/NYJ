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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('event_id')->nullable();
            $table->foreignId('ticket_id')->nullable();
            $table->enum('discount_amount_type', ['fixed', 'percentage']);
            $table->date('valid_from_date')->nullable();
            $table->time('valid_from_time')->nullable();
            $table->date('valid_to_date')->nullable();
            $table->time('valid_to_time')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->enum('available_for', ['all', 'in_house']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
