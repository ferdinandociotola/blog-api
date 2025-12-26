<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'content' => $validated['content']
        ]);

        $comment->load('user');

        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    public function destroy(Comment $comment)
    {
        // Verifica che l'utente sia il proprietario del commento
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        
        return response()->json(['message' => 'Comment deleted'], 200);
    }
}
