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
}
