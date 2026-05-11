<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\DailyTopic;
use App\Models\Embedding;
use App\Services\ModerationService;
use App\Services\EmbeddingService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')
            ->where('isFlagged', false)
            ->latest()
            ->get();

        $todayTopic = DailyTopic::today()->with('user')->first();

        return view('posts.index', compact('posts', 'todayTopic'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|min:3|max:500',
        ]);

        $moderation = new ModerationService();

        if (!$moderation->isAllowed($request->body)) {
            return back()->withErrors([
                'body' => 'Il tuo post è stato bloccato dalla moderazione automatica.'
            ])->withInput();
        }

        $post = Post::create([
            'userId' => auth()->id(),
            'body' => $request->body,
        ]);

        // Genera embedding automaticamente
        try {
            $embeddingService = new EmbeddingService();
            $vector = $embeddingService->getEmbedding($post->body);
            Embedding::create([
                'postId' => $post->id,
                'vector' => $vector,
            ]);
        } catch (\Exception $e) {
            // Se HuggingFace non è disponibile, il post viene pubblicato comunque
        }

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if ($post->userId !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}