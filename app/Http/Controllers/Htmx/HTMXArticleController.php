<?php

namespace App\Http\Controllers\Htmx;

use App\Models\User;
use App\Models\Article;
use App\Support\Helpers;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticlePostCommentRequest;

class HTMXArticleController extends Controller
{
    public function show(Article $article)
    {
        $isArticleFavoritedByUser = false;
        $article->load(['favoritedUsers', 'user.followers']);

        if (auth()->check()) {
            $isArticleFavoritedByUser = $article->favoritedByUser(auth()->user());
        }

        return view('articles.partials.show', [
            'article' => $article,
            'favorite_count' => $article->favoritedUsers->count(),
            'is_favorited' => $isArticleFavoritedByUser
        ])
        .view('components.navbar', ['navbar_active' => ''])
        .view('components.htmx.head', [
            'page_title' => Str::words($article->title, 40, '') . ' —'
        ]);
    }

    public function favorite(Article $article)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        $isArticleFavoritedByUser = $article->toggleUserFavorite(auth()->user());

        return view('articles.partials.favorite-button', [
            'article' => $article,
            'favorite_count' => $article->favoritedUsers->count(),
            'is_favorited' => $isArticleFavoritedByUser,
            'oob_swap' => true
        ]);
    }

    public function follow(User $user)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        $isUserFollowed = auth()->user()->toggleFollowUser($user);

        return view('articles.partials.follow-button', [
            'user' => $user,
            'is_followed' => $isUserFollowed,
            'follower_count' => $user->followers->count(),
            'oob_swap' => true
        ]);
    }

    public function comments(Article $article)
    {
        $article->load(['comments.user']);

        $comments = $article->comments()->latest()->get();

        return view('articles.partials.comments-wrapper', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function postComment(Article $article, ArticlePostCommentRequest $request)
    {
        $validated = $request->safe()->only(['comment']);

        $comment = $article->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => $validated['comment']
        ]);

        return view('articles.partials.comment-card', [
            'comment' => $comment
        ])
        .view('articles.partials.comment-form', [
            'article' => $article,
            'oob_swap' => true
        ]);
    }

    public function delete(Article $article)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        $article->delete();

        return response()->view('components.redirect', [
                'hx_get' => '/htmx/users/' . auth()->user()->username,
                'hx_target' => '#app-body',
                'hx_trigger' => 'load',
            ])
            ->withHeaders([
                'HX-Push-Url' => '/users/' . auth()->user()->username
            ]);
    }
}