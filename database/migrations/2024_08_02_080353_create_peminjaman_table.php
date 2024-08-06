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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjam');
            $table->foreignId('id_swa')->constrained('siswa', 'id_swa')->onDelete('cascade');
            $table->foreignId('id_bku')->constrained('buku', 'id_bku')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tenggat_kembali');
            $table->date('tanggal_kembali')->nullable();
            $table->Integer('denda')->nullable();;
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
