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
        Schema::create('car_parks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_slot_id')->nullable()->constrained('parking_slots')->nullOnDelete()->cascadeOnUpdate();
            $table->string('license_plate');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->double('parking_fee')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_parks');
    }
};
