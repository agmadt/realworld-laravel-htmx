<?php

namespace App\Support;

use App\Models\User;

class Helpers
{
    public static function feedNavbarItems(): array
    {
        $navbarItems = [];

        if (!auth()->guest()) {
            $navbarItems['personal'] = [
                'title' => 'Your Feed',
                'is_active' => false,
                'hx_get_url' => '/htmx/home/your-feed',
                'hx_push_url' => '/your-feed'
            ];
        }

        $navbarItems['global'] = [
            'title' => 'Global Feed',
            'is_active' => false,
            'hx_get_url' => '/htmx/home/global-feed',
            'hx_push_url' => '/'
        ];

        return $navbarItems;
    }

    public static function userFeedNavbarItems(User $user): array
    {
        return [
            'personal' => [
                'title' => 'My Articles',
                'is_active' => true,
                'url' => '/users/' . $user->username,
                'hx_get_url' => '/htmx/users/' . $user->username . '/articles'
            ],
            'favorite' => [
                'title' => 'Favorited Articles',
                'is_active' => false,
                'url' => '/users/' . $user->username . '/favorites',
                'hx_get_url' => '/htmx/users/' . $user->username . '/favorites'
            ]
        ];
    }

    public static function redirectToHome()
    {
        return response()->view('components.redirect', [
                'hx_get' => '/htmx/home',
                'hx_target' => '#app-body',
                'hx_trigger' => 'load',
            ])
            ->withHeaders([
                'HX-Push-Url' => '/',
                'HX-Reswap' => 'none'
            ]);
    }

    public static function redirectToSignIn()
    {
        return response()->view('components.redirect', [
                'hx_get' => '/htmx/sign-in',
                'hx_target' => '#app-body',
                'hx_trigger' => 'load',
            ])
            ->withHeaders([
                'HX-Push-Url' => '/sign-in',
                'HX-Reswap' => 'none'
            ]);
    }
}
