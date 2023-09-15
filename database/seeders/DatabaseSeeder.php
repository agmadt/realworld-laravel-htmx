<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->create([
            'email' => 'test@email.com'
        ]);

        $users = User::factory()->count(20)->create();

        foreach ($users as $user) {
            $user->followers()->attach($users->random(rand(0, 5)));
        }

        $articles = Article::factory()
            ->count(30)
            ->state(new Sequence(fn() => [
                'user_id' => $users->random(),
            ]))
            ->create();

        $tags = Tag::factory()->count(20)->create();

        foreach ($articles as $article) {
            $article->tags()->attach($tags->random(rand(0, 6)));
            $article->favoritedUsers()->attach($users->random(rand(0, 8)));
        }

        Comment::factory()
            ->count(60)
            ->state(new Sequence(fn() => [
                'article_id' => $articles->random(),
                'user_id' => $users->random(),
            ]))
            ->create();
    }
}
