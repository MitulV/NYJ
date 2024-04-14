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
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('organizer_id');
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date');
            $table->time('end_time')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->enum('status', ['Draft', 'Published', 'Cancelled'])->default('Draft');
            $table->text('long_description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->string('age_restrictions')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->dateTime('booking_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
