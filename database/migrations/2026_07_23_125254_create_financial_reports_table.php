<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_id')
                ->unique()
                ->constrained('programs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('report_number', 30)->unique();
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('total_income', 15, 2)->default(0);
            $table->decimal('total_expense', 15, 2)->default(0);
            $table->decimal('remaining_budget', 15, 2)->default(0);

            $table->enum('status', [
                'Draft',
                'Submitted',
                'Approved',
                'Revision',
            ])->default('Draft');

            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};