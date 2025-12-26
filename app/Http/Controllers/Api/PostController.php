<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'categories'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return new PostCollection($posts);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'categories', 'comments.user']);
        
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null
        ]);

        if (isset($validated['category_ids'])) {
            $post->categories()->attach($validated['category_ids']);
        }

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'status' => 'in:draft,published',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (isset($validated['status']) && $validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if (isset($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        
        return response()->json(['message' => 'Post deleted'], 200);
    }
}
