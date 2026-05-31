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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id('bdt_id')->autoIncrement();
            $table->foreignId('bdt_use_id')
                    ->references('use_id')
                    ->on('users');
            $table->string('bdt_name', 50);
            $table->decimal('bdt_limit', 10, 2);
            $table->decimal('bdt_current_expense', 10, 2)->nullable();
            $table->enum('bdt_color', ['AMBAR', 'VIOLETA', 'AZUL', 'ROSA', 'ESMERALDA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
