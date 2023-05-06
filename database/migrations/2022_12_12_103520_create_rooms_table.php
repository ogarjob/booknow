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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['one-bed', 'two-bed', 'three-bed', 'studio', 'five-bed']);
            $table->text('description')->nullable();
            $table->char('room_no')->nullable();
            $table->char('floor_no')->nullable();
            $table->char('building_no')->nullable();
            $table->integer('price');
            $table->integer('security_deposit')->default(30000);
            $table->json('meta')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('featured_at')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
