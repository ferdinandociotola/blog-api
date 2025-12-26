<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $posts = Post::where('status', 'published')->get();

        foreach ($posts as $post) {
            // 2-5 commenti per ogni post
            $numComments = rand(2, 5);
            
            for ($i = 1; $i <= $numComments; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => "Questo è un commento di test numero $i per il post '{$post->title}'"
                ]);
            }
        }
    }
}
