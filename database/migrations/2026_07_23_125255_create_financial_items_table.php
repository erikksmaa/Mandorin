<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('financial_report_id')
                ->constrained('financial_reports')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('type', [
                'Income',
                'Expense',
            ]);

            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->string('receipt')->nullable();
            $table->date('transaction_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_items');
    }
};