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
        Schema::create('history', function (Blueprint $table) {
            $table->id('id_history');
            $table->Integer('id_swa');
            $table->string('nama_swa');
            $table->Integer('id_bku');
            $table->string('judul');
            $table->date('tanggal_pinjam');
            $table->date('tenggat_kembali');
            $table->date('tanggal_kembali');
            $table->Integer('denda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
