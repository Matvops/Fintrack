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
            $table->id('use_id')->autoIncrement();
            $table->string('use_name', 50);
            $table->string('use_email')->unique();
            $table->string('use_verification_token')->unique()->nullable();
            $table->timestamp('use_email_verified_at')->nullable();
            $table->text('use_password')->unique();
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
