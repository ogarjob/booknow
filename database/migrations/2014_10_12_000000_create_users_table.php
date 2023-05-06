<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 45);
            $table->string('last_name', 45)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 45)->nullable()->unique();
            $table->enum('gender', ['M', 'F'])->default('M')->index();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('id_card')->nullable();
            $table->enum('type', ['admin', 'agent', 'customer', 'vendor'])->nullable()->default('customer');
            $table->foreignId('role_id')->nullable()->constrained();
            $table->boolean('notifiable')->default(false);
            $table->string('password')->nullable();
            $table->integer('login_count')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->dateTime('banned_until')->nullable();
            $table->json('meta')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->authors();
            $table->softDeletes();

            $table->fullText(['last_name', 'first_name', 'phone', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
