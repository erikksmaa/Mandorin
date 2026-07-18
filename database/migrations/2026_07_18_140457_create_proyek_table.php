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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mandor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->date('tanggal_mulai');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'berjalan', 'selesai'])->default('menunggu');
            $table->integer('progres_persen')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
    }
};
