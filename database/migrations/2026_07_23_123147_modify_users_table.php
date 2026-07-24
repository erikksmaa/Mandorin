<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->after('id')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('phone', 20)->unique()->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->enum('gender', ['L', 'P'])->nullable()->after('avatar');
            $table->date('birth_date')->nullable()->after('gender');
            $table->text('address')->nullable()->after('birth_date');
            $table->boolean('is_active')->default(true)->after('address');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id',
                'phone',
                'avatar',
                'gender',
                'birth_date',
                'address',
                'is_active',
                'last_login_at',
                'deleted_at',
            ]);
        });
    }
};