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
        Schema::create('dpr_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyek')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('catatan');
            $table->integer('progres_persen');
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpr_entries');
    }
};
