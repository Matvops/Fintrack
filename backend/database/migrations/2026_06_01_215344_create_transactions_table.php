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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('tra_id')->autoIncrement();
            $table->foreignId('tra_use_id')
                    ->references('use_id')
                    ->on('users');
            $table->foreignId('tra_bdt_id')
                    ->nullable()
                    ->references('bdt_id')
                    ->on('budgets');
            $table->string('tra_description');
            $table->decimal('tra_value', 10, 2);
            $table->timestamp('tra_date');
            $table->enum('tra_type', ['EXPENSE', 'INCOME']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
