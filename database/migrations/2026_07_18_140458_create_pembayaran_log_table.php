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
        Schema::create('pembayaran_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyek')->cascadeOnDelete();
            $table->integer('termin_ke');
            $table->decimal('nominal', 12, 2);
            $table->date('tanggal');
            $table->string('bukti_kuitansi');
            $table->boolean('dikonfirmasi_pelanggan')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_log');
    }
};
