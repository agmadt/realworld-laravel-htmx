<?php

namespace App\Http\Controllers;

use App\Models\Article;

class EditorController extends Controller
{
    public function create()
    {
        return view('editor.create', [
            'navbar_active' => 'editor',
            'page_title' => 'Editor —'
        ]);
    }

    public function edit(Article $article)
    {
        return view('editor.edit', [
            'article' => $article, 
            'navbar_active' => '',
            'page_title' => 'Editor —'
        ]);
    }
}
