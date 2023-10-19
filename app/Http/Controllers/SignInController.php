<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;

class SignInController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('sign-in.index', [
            'navbar_active' => 'sign-in',
            'page_title' => 'Sign In —'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}