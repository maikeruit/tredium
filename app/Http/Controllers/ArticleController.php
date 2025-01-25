<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['tags', 'views', 'likes'])
            ->latest()
            ->paginate(10);

        $tags = Tag::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->get();

        return view('articles.index', compact('articles', 'tags'));
    }

    public function show(Article $article)
    {
        $article->load(['tags', 'comments' => function ($query) {
            $query->whereNull('parent_id')
                  ->with('replies');
        }, 'views', 'likes']);

        $article->views()->increment('count');

        return view('articles.show', compact('article'));
    }
}
