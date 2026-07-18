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
        Schema::create('mandor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('keahlian');
            $table->string('kategori');
            $table->string('lokasi_teks');
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('jumlah_proyek_selesai')->default(0);
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('dokumen_ktp');
            $table->string('dokumen_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandor_profiles');
    }
};
