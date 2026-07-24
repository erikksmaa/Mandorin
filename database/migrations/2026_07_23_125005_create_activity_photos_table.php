<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_log_id')
                ->constrained('activity_logs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('photo');
            $table->text('caption')->nullable();

            $table->enum('photo_type', [
                'Before',
                'Progress',
                'After',
                'Documentation',
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_photos');
    }
};