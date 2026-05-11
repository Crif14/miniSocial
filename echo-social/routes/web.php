<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DailyTopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('posts.index');
    }
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('posts.index');
    })->name('dashboard');

    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
    Route::post('/feed', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route solo admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/topics/create', [DailyTopicController::class, 'create'])->name('topics.create');
        Route::post('/topics', [DailyTopicController::class, 'store'])->name('topics.store');

        // Moderazione commenti
        Route::get('/admin/comments', [CommentController::class, 'adminIndex'])->name('admin.comments');
        Route::post('/admin/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::post('/admin/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    });

    Route::get('/topics', [DailyTopicController::class, 'index'])->name('topics.index');
    // Ricerca semantica
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/embeddings', [SearchController::class, 'generateEmbeddings'])->name('search.embeddings');
});

require __DIR__.'/auth.php';