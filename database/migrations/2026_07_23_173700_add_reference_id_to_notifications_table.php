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
        if (Schema::hasTable('notifications') && !Schema::hasColumn('notifications', 'reference_id')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->unsignedBigInteger('reference_id')->nullable()->after('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'reference_id')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropColumn('reference_id');
            });
        }
    }
};
