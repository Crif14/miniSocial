<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aggiunge colonne alla tabella users già esistente
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'admin'])->default('user')->after('email');
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });

        // Rimuove tabelle inutili di Laravel
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');

        // Cache (necessaria per il rate limiter del login)
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // Posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('isFlagged')->default(false);
            $table->string('flaggedReason')->nullable();
            $table->timestamps();
        });

        // Comments — con campi moderazione
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postId')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('isFlagged')->default(false);
            $table->timestamp('flaggedAt')->nullable();
            $table->timestamp('reviewedAt')->nullable();
            $table->string('reviewStatus')->nullable();
            $table->timestamps();
        });

        // Daily Topics
        Schema::create('dailyTopics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('topicDate')->unique();
            $table->timestamps();
        });

        // Post Likes
        Schema::create('postLikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->cascadeOnDelete();
            $table->foreignId('postId')->constrained('posts')->cascadeOnDelete();
            $table->timestamp('createdAt')->useCurrent();
            $table->unique(['userId', 'postId']);
        });

        // Embeddings
        Schema::create('embeddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postId')->constrained('posts')->cascadeOnDelete();
            $table->json('vector');
            $table->timestamp('createdAt')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('embeddings');
        Schema::dropIfExists('postLikes');
        Schema::dropIfExists('dailyTopics');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};