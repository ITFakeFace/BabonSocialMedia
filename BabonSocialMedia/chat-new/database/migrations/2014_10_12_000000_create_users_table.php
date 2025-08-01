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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //account
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->smallInteger('level')->default('0');
            $table->rememberToken();
            //profile
            $table->string('username');
            $table->string('avatar')->nullable();
            $table->string('coverPhoto')->nullable();
            $table->string('personalImage')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
