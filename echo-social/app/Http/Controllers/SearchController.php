<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Embedding;
use App\Services\EmbeddingService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $posts = collect();

        if ($query) {
            $embeddingService = new EmbeddingService();

            // Recupera tutti gli embeddings salvati
            $embeddings = Embedding::with('post.user', 'post.comments', 'post.likes')
                ->get();

            if ($embeddings->isEmpty()) {
                return view('search.index', compact('posts', 'query'))
                    ->with('warning', 'Nessun embedding trovato. Pubblica alcuni post prima!');
            }

            // Costruisce array postId => vector
            $postEmbeddings = $embeddings->mapWithKeys(fn($e) => [
                $e->postId => $e->vector
            ])->toArray();

            // Calcola similarità
            $scores = $embeddingService->search($query, $postEmbeddings);

            // Prende i top 10 post con score > 0.3
            $topPostIds = array_keys(array_filter($scores, fn($s) => $s > 0.3));
            $topPostIds = array_slice($topPostIds, 0, 10);

            // Recupera i post in ordine di similarità
            $posts = collect($topPostIds)->map(function ($postId) use ($embeddings) {
                return $embeddings->firstWhere('postId', $postId)?->post;
            })->filter()->where('isFlagged', false);
        }

        return view('search.index', compact('posts', 'query'));
    }

    public function generateEmbeddings()
    {
        $embeddingService = new EmbeddingService();

        $posts = Post::where('isFlagged', false)
            ->doesntHave('embedding')
            ->get();

        foreach ($posts as $post) {
            $vector = $embeddingService->getEmbedding($post->body);

            Embedding::create([
                'postId' => $post->id,
                'vector' => $vector,
            ]);
        }

        return redirect()->route('search.index')
            ->with('success', "Generati embeddings per {$posts->count()} post!");
    }
}