<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Htmx\HTMXHomeController;
use App\Http\Controllers\Htmx\HTMXUserController;
use App\Http\Controllers\Htmx\HTMXEditorController;
use App\Http\Controllers\Htmx\HTMXSignInController;
use App\Http\Controllers\Htmx\HTMXSignUpController;
use App\Http\Controllers\Htmx\HTMXArticleController;
use App\Http\Controllers\Htmx\HTMXSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/global-feed', [HomeController::class, 'index']);

Route::get('/your-feed', [HomeController::class, 'yourFeed'])->middleware('auth');
Route::get('/tag-feed/{tag}', [HomeController::class, 'tags']);

Route::get('/sign-in', [SignInController::class, 'index'])->middleware('guest')->name('login');
Route::post('/sign-in', [SignInController::class, 'signIn'])->middleware('guest');
Route::get('/logout', [SignInController::class, 'logout'])->middleware('auth');

Route::get('/sign-up', [SignUpController::class, 'index'])->middleware('guest');

Route::get('/articles/{article}', [ArticleController::class, 'show']);

Route::get('/editor', [EditorController::class, 'create'])->middleware('auth');
Route::get('/editor/{article}', [EditorController::class, 'edit'])->middleware('auth');

Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/favorites', [UserController::class, 'favorites']);

Route::get('/settings', [SettingsController::class, 'index'])->middleware('auth');

Route::prefix('htmx')->group(function() {

    Route::get('/home', [HTMXHomeController::class, 'index']);
    Route::post('/home/articles/{article}/favorite', [HTMXHomeController::class, 'favorite']);
    
    Route::get('/articles/{article}', [HTMXArticleController::class, 'show']);
    Route::post('/articles/{article}/favorite', [HTMXArticleController::class, 'favorite']);
    Route::post('/articles/follow-user/{user}', [HTMXArticleController::class, 'follow']);
    Route::get('/articles/{article}/comments', [HTMXArticleController::class, 'comments']);
    Route::post('/articles/{article}/comments', [HTMXArticleController::class, 'postComment']);
    Route::delete('/articles/{article}', [HTMXArticleController::class, 'delete']);

    Route::get('/home/feed-navigation', [HTMXHomeController::class, 'feedNavigation']);
    Route::get('/home/global-feed', [HTMXHomeController::class, 'globalFeed']);
    Route::get('/home/your-feed', [HTMXHomeController::class, 'yourFeed']);
    Route::get('/home/tag-list', [HTMXHomeController::class, 'tagList']);
    Route::get('/home/tag-feed/{tag}', [HTMXHomeController::class, 'tagFeed']);

    Route::get('/editor', [HTMXEditorController::class, 'create']);
    Route::post('/editor', [HTMXEditorController::class, 'store']);
    Route::get('/editor/{article}', [HTMXEditorController::class, 'edit']);
    Route::post('/editor/{article}', [HTMXEditorController::class, 'update']);
    
    Route::get('/popular-tags', [HTMXHomeController::class, 'popularTags']);

    Route::get('/sign-in', [HTMXSignInController::class, 'index']);
    Route::post('/sign-in', [HTMXSignInController::class, 'signIn']);
    Route::post('/logout', [HTMXSignInController::class, 'logout']);

    Route::get('/sign-up', [HTMXSignUpController::class, 'index']);
    Route::post('/sign-up', [HTMXSignUpController::class, 'signUp']);

    Route::get('/settings', [HTMXSettingsController::class, 'index']);
    Route::post('/settings', [HTMXSettingsController::class, 'update']);

    Route::get('/users/{user}', [HTMXUserController::class, 'show']);
    Route::get('/users/{user}/articles', [HTMXUserController::class, 'articles']);
    Route::get('/users/{user}/favorites', [HTMXUserController::class, 'favoriteArticles']);
    Route::post('/users/{user}/follow', [HTMXUserController::class, 'follow']);
    Route::post('/users/articles/{article}/favorite', [HTMXUserController::class, 'favorite']);
});