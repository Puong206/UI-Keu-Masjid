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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('category');
            $table->string('cat_color', 20)->default('green');
            $table->bigInteger('amount'); // stored as integer (no dots), e.g. 395500
            $table->enum('type', ['pemasukan', 'pengeluaran']);
            $table->timestamps();

            $table->index(['type', 'date']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

