<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->nullable()->constrained();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('reference', 45)->unique();
            $table->integer('amount');
            $table->enum('channel', ['paystack', 'cash']);
            $table->timestamp('paid_at')->nullable()->index();
            $table->authors();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
