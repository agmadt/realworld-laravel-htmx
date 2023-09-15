<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        $isArticleFavoritedByUser = false;
        $article->load(['comments.user', 'user', 'favoritedUsers']);

        if (auth()->check()) {
            $isArticleFavoritedByUser = $article->favoritedByUser(auth()->user());
        }

        return view('articles.detail', [
            'article' => $article,
            'comments' => $article->comments()->latest()->get(),
            'favorite_count' => $article->favoritedUsers->count(),
            'is_favorited' => $isArticleFavoritedByUser,
            'page_title' => Str::words($article->title, 40, '') . ' —'
        ]);
    }
}
