<?php

namespace App\Http\Controllers\Htmx;

use App\Models\User;
use App\Models\Article;
use App\Support\Helpers;
use App\Http\Controllers\Controller;

class HTMXUserController extends Controller
{
    public function show(User $user)
    {
        $isUserFollowed = false;
        $navbarActive = 'none';
        $user->load(['articles', 'followers']);

        $userFeedNavbarItems = Helpers::userFeedNavbarItems($user);

        if (auth()->check() && auth()->user()->following($user)) {
            $isUserFollowed = true;
        }

        if ($user->isSelf) {
            $navbarActive = 'profile';
        }

        return view('users.partials.show', [
                'user' => $user,
                'articles' => $user->articles,
                'user_feed_navbar_items' => $userFeedNavbarItems,
                'follower_count' => $user->followers->count(),
                'is_followed' => $isUserFollowed
            ])
            .view('components.navbar', ['navbar_active' => $navbarActive]);
    }

    public function articles(User $user)
    {
        $user->load(['articles']);

        $userFeedNavbarItems = Helpers::userFeedNavbarItems($user);

        return view('users.partials.post-preview', [
                'articles' => $user->articles
            ])
            .view('users.partials.feed-navigation', [
                'user_feed_navbar_items' => $userFeedNavbarItems
            ])
            .view('components.htmx.head', [
                'page_title' => $user->username . ' —'
            ]);
    }

    public function favoriteArticles(User $user)
    {
        $user->load(['favorites']);

        $userFeedNavbarItems = Helpers::userFeedNavbarItems($user);
        $userFeedNavbarItems['personal']['is_active'] = false;
        $userFeedNavbarItems['favorite']['is_active'] = true;

        return view('users.partials.post-preview', [
                'articles' => $user->favorites,
                'is_current_user' => $user->isSelf
            ])
            .view('users.partials.feed-navigation', [
                'user_feed_navbar_items' => $userFeedNavbarItems
            ])
            .view('components.htmx.head', [
                'page_title' => 'Articles favorited by ' .  $user->username . ' —'
            ]);
    }

    public function follow(User $user)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }
        
        $isUserFollowed = auth()->user()->toggleFollowUser($user);

        return view('users.partials.follow-button', [
            'user' => $user,
            'follower_count' => $user->followers->count(),
            'is_followed' => $isUserFollowed,
        ]);
    }

    public function favorite(Article $article)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        // check if the current user are executing this function
        if (str_contains(request()->server()['HTTP_REFERER'], auth()->user()->username)) {
            $isDeleteItem = true;
        }

        $isArticleFavoritedByUser = $article->toggleUserFavorite(auth()->user());

        return response()->view('users.partials.favorite-button', [
            'article' => $article,
            'favorite_count' => $article->favoritedUsers->count(),
            'is_favorited' => $isArticleFavoritedByUser
        ]);
    }
}
