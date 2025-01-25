<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleLikeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('articles.comments.store');
Route::post('/articles/{article}/like', [ArticleLikeController::class, 'store'])->name('articles.like');
Route::post('/articles/{article}/increment-views', [ArticleController::class, 'incrementViews'])
    ->name('articles.increment-views');
