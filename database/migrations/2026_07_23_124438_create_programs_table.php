<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('leader_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('program_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('program_code', 30)->unique();
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->longText('description')->nullable();
            $table->text('objective')->nullable();
            $table->text('target')->nullable();
            $table->string('location')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->string('proposal_file')->nullable();

            $table->enum('proposal_status', [
                'Pending',
                'Verified',
                'Revision',
                'Rejected',
            ])->default('Pending');

            $table->text('proposal_notes')->nullable();

            $table->enum('status', [
                'Draft',
                'Submitted',
                'Approved',
                'Running',
                'Completed',
                'Cancelled',
            ])->default('Draft');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};