<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_attachments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('community_post_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('file');

            $table->string('caption')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_attachments');
    }
};