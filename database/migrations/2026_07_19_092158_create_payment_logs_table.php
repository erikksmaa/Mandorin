<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('payment_number');

            $table->decimal('amount', 15, 2);

            $table->date('payment_date');

            $table->string('receipt')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'rejected'
            ])->default('pending');

            $table->timestamps();
            $table->unique([
                'project_id',
                'payment_number'
            ]);

            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};