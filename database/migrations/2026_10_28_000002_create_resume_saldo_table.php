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
        Schema::create('resume_saldo', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7); // format: YYYY-MM e.g. "2026-04"
            $table->string('category');
            $table->string('cat_color', 20)->default('green');
            $table->bigInteger('saldo_awal');
            $table->bigInteger('pemasukan');
            $table->bigInteger('pengeluaran');
            $table->bigInteger('saldo_akhir');
            $table->timestamps();

            $table->index('period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_saldo');
    }
};

