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
        Schema::create('goals', function (Blueprint $table) {
            $table->id('gls_id')->autoIncrement();
            $table->string('gls_name')->unique();
            $table->string('gls_balance');
            $table->string('gls_balance_target');
            $table->enum('gls_color', ['AMBAR', 'ESMERALDA', 'AZUL', 'ROSA', 'VIOLETA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
