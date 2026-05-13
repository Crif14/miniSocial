<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DailyTopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
ROTTA DI WELCOME
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('posts.index');
    }
    return view('welcome');
});

// Rotte per utente autenticato
Route::middleware(['auth'])->group(function () {

    //Reindirizzamento automatico al Feed
    Route::get('/dashboard', function () {
        return redirect()->route('posts.index');
    })->name('dashboard');

    // GESTIONE POST
    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
    Route::post('/feed', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // GESTIONE COMMENTI
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // LIKE
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

    // PROFILO UTENTE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // AREA AMMINISTRATORE
    Route::middleware(['admin'])->group(function () {
        
        // Creazione del Topic del Giorno
        Route::get('/topics/create', [DailyTopicController::class, 'create'])->name('topics.create');
        Route::post('/topics', [DailyTopicController::class, 'store'])->name('topics.store');

        // Moderazione
        Route::get('/admin/comments', [CommentController::class, 'adminIndex'])->name('admin.comments');
        Route::post('/admin/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::post('/admin/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    });

    // STORICO TOPIC
    Route::get('/topics', [DailyTopicController::class, 'index'])->name('topics.index');

    // RICERCA SEMANTICA
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/embeddings', [SearchController::class, 'generateEmbeddings'])->name('search.embeddings');
});

// CARICAMENTO ROTTE DI AUTENTICAZIONE (Login, Register, Logout)
require __DIR__.'/auth.php';