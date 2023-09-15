<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Helpers;

class UserController extends Controller
{
    public function show(User $user)
    {
        $isUserFollowed = false;
        $user->load(['articles', 'followers']);

        $userFeedNavbarItems = Helpers::userFeedNavbarItems($user);

        if (auth()->check() && auth()->user()->following($user)) {
            $isUserFollowed = true;
        }

        return view('users.show', [
            'user' => $user,
            'navbar_active' => 'profile',
            'user_feed_navbar_items' => $userFeedNavbarItems,
            'follower_count' => $user->followers->count(),
            'is_followed' => $isUserFollowed,
            'page_title' => $user->username . ' —'
        ]);
    }

    public function favorites(User $user)
    {

        $isUserFollowed = false;
        $user->load(['articles', 'followers']);
        
        $userFeedNavbarItems = Helpers::userFeedNavbarItems($user);
        $userFeedNavbarItems['personal']['is_active'] = false;
        $userFeedNavbarItems['favorite']['is_active'] = true;

        if (auth()->check() && auth()->user()->following($user)) {
            $isUserFollowed = true;
        }

        return view('users.show', [
            'load_favorites' => true,
            'user' => $user,
            'navbar_active' => 'profile',
            'user_feed_navbar_items' => $userFeedNavbarItems,
            'follower_count' => $user->followers->count(),
            'is_followed' => $isUserFollowed,
            'page_title' => 'Articles favorited by ' .  $user->username . ' —'
        ]);
    }
}
