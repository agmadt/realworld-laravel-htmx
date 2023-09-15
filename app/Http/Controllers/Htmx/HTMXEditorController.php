<?php

namespace App\Http\Controllers\Htmx;

use App\Models\Article;
use App\Support\Helpers;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditorStoreArticleRequest;

class HTMXEditorController extends Controller
{
    public function create()
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }
        
        return view('editor.partials.form')
            .view('components.navbar', ['navbar_active' => 'editor'])
            .view('components.htmx.head', [
                'page_title' => 'Editor —'
            ]);
    }

    public function store(EditorStoreArticleRequest $request)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        $validated = $request->safe()->all();

        $article = Article::create([
            'user_id' => auth()->user()->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'body' => $validated['content']
        ]);

        if ($validated['tags']) {

            $tags = json_decode($validated['tags']);
            $tagsArray = [];

            foreach ($tags as $key => $tag) {
                $tagsArray[] = $tag->value;
            }

            $article->attachTags($tagsArray);
        }

        return response()->view('components.redirect', [
                'hx_get' => '/htmx/articles/' . $article->slug,
                'hx_target' => '#app-body',
                'hx_trigger' => 'load',
            ])
            ->withHeaders([
                'HX-Push-Url' => '/articles/' . $article->slug
            ]);
    }

    public function edit(Article $article)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }
        
        return view('editor.partials.form', ['article' => $article])
            .view('components.navbar', ['navbar_active' => ''])
            .view('components.htmx.head', [
                'page_title' => 'Editor —'
            ]);
    }

    public function update(EditorStoreArticleRequest $request, Article $article)
    {
        if (auth()->guest()) {
            return Helpers::redirectToSignIn();
        }

        $validated = $request->safe()->all();

        $article->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'body' => $validated['content']
        ]);

        if ($validated['tags']) {

            $tags = json_decode($validated['tags']);
            $tagsArray = [];

            foreach ($tags as $key => $tag) {
                $tagsArray[] = $tag->value;
            }

            $article->attachTags($tagsArray);
        }

        return response()->view('components.redirect', [
                'hx_get' => '/htmx/articles/' . $article->slug,
                'hx_target' => '#app-body',
                'hx_trigger' => 'load',
            ])
            ->withHeaders([
                'HX-Push-Url' => '/articles/' . $article->slug
            ]);
    }
}
