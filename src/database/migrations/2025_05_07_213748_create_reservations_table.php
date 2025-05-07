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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->datetime('reservation_start');
            $table->datetime('reservation_end');

            $table->foreignId('room_id')->references('id')->on('rooms');
            $table->foreignId('booked_by')->references('id')->on('users');
            $table->foreignId('reviewed_by')->nullable()->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
