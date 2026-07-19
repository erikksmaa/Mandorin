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
        Schema::create('contractor_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('profile_photo')->nullable();

            $table->text('bio')->nullable();

            $table->string('address');

            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            $table->decimal('rating', 3, 2)->default(0);

            $table->unsignedInteger('total_reviews')->default(0);

            $table->unsignedInteger('total_projects')->default(0);

            $table->string('identity_document')->nullable();

            $table->string('certificate_document')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_profiles');
    }
};