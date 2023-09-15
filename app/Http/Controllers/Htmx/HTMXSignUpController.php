<?php

namespace App\Http\Controllers\Htmx;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;

class HTMXSignUpController extends Controller
{
    public function index()
    {
        return view('sign-up.partials.index')
            .view('components.navbar', [
                'navbar_active' => 'sign-up'
            ])
            .view('components.htmx.head', [
                'page_title' => 'Sign Up —'
            ]);
    }

    public function signUp(SignUpRequest $request)
    {
        $validated = $request->safe()->only(['username', 'email', 'password']);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        auth()->login($user);

        return response()->view('components.redirect', [
            'hx_get' => '/htmx/home',
            'hx_target' => '#app-body',
            'hx_trigger' => 'load',
        ])
        ->withHeaders([
            'HX-Replace-Url' => '/',
            'HX-Reswap' => 'none'
        ]);
    }
}
