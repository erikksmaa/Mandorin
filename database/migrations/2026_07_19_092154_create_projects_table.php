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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('project_code')->unique();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('contractor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description');

            $table->text('address');

            $table->timestamp('requested_at')->useCurrent();

            $table->date('start_date')->nullable();

            $table->date('estimated_finish_date')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->unsignedTinyInteger('progress_percentage')
                ->default(0);

            $table->enum('status', [
                'pending',
                'accepted',
                'in_progress',
                'completed',
                'rejected',
                'cancelled'
            ])->default('pending');

            $table->softDeletes();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('contractor_id');
            $table->index('service_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};