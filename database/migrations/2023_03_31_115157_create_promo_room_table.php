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
        Schema::create('promo_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->timestamps();

            $table->unique(['promo_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_room');
    }
};
