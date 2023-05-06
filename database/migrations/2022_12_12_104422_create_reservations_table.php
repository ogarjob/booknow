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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('promo_id')->nullable()->constrained();
            $table->foreignId('agent_user_id')->nullable()->constrained('users');
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->integer('room_price');
            $table->integer('room_security_deposit');
            $table->float('discount')->nullable();
            $table->float('discount_amount', 10)->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            $table->authors();
            $table->timestamps();
            $table->softDeletes();
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
