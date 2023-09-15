<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'page_title' => 'Home —'
        ]);
    }

    public function yourFeed()
    {
        return view('home.index', [
            'personal' => true,
            'page_title' => 'Your feed —'
        ]);
    }

    public function tags(Tag $tag)
    {
        return view('home.index', [
            'tag' => $tag,
            'page_title' => Str::words($tag->name, 40, '') . ' —'
        ]);
    }
}
