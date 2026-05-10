<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\ModerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:1|max:300',
        ]);

        $moderation = new ModerationService();

        if (!$moderation->isAllowed($request->body)) {
            // Salva il commento ma flaggato — non visibile finché admin non approva
            Comment::create([
                'postId' => $post->id,
                'userId' => auth()->id(),
                'body' => $request->body,
                'isFlagged' => true,
                'flaggedAt' => Carbon::now(),
            ]);

            return back()->with('moderation_warning',
                'Il tuo commento è in attesa di revisione da parte di un moderatore.'
            );
        }

        Comment::create([
            'postId' => $post->id,
            'userId' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->userId !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->route('posts.index');
    }

    public function approve(Comment $comment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->update([
            'isFlagged' => false,
            'reviewedAt' => Carbon::now(),
            'reviewStatus' => 'approved',
        ]);

        return redirect()->route('admin.comments');
    }

    public function reject(Comment $comment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->update([
            'reviewedAt' => Carbon::now(),
            'reviewStatus' => 'rejected',
        ]);

        return redirect()->route('admin.comments');
    }
    public function adminIndex()
    {
        $pendingComments = Comment::with('user', 'post')
            ->where('isFlagged', true)
            ->whereNull('reviewStatus')
            ->latest('flaggedAt')
            ->get();

        return view('admin.comments', compact('pendingComments'));
    }
}