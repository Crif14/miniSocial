<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postLikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('postId')->constrained('posts')->cascadeOnDelete();
            $table->timestamp('createdAt')->useCurrent();
            $table->unique(['userId', 'postId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postLikes');
    }
};