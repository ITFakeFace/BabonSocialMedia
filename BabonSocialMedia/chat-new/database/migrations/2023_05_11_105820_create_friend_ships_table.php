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
        Schema::create('friend_ships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID_request');
            $table->unsignedBigInteger('userID_receive');
            $table->boolean('status');
            $table->foreign('userID_request')->references('id')->on('users');
            $table->foreign('userID_receive')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_ships');
    }
};
