<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Support\Defaults;

class SignUpController extends Controller
{
    public function index()
    {
        return view('sign-up.index', [
            'navbar_active' => 'sign-up',
            'page_title' => 'Sign Up —'
        ]);
    }

    public function signUp()
    {
    }
}