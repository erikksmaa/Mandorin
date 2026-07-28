<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_posts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title',150)->nullable();

            $table->text('content');

            $table->boolean('is_pinned')
                ->default(false);

            $table->boolean('is_locked')
                ->default(false);

            $table->unsignedInteger('views')
                ->default(0);

            $table->unsignedInteger('likes_count')
                ->default(0);

            $table->unsignedInteger('comments_count')
                ->default(0);

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};