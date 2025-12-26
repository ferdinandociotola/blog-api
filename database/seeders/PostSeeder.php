<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Crea un utente di test
        $user = User::create([
            'name' => 'Nando Developer',
            'email' => 'nando@test.com',
            'password' => bcrypt('password123')
        ]);

        // Prendi tutte le categorie
        $categories = Category::all();

        // Crea 10 posts
        for ($i = 1; $i <= 10; $i++) {
            $title = "Post di Test Numero $i";
            
            $post = Post::create([
                'user_id' => $user->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "Questo è il contenuto del post numero $i. Lorem ipsum dolor sit amet.",
                'status' => $i <= 7 ? 'published' : 'draft',
                'published_at' => $i <= 7 ? now()->subDays(10 - $i) : null
            ]);

            // Associa 1-3 categorie random
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')
            );
        }
    }
}
