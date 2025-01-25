<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $selectedTag = null;

        if ($request->has('tag')) {
            $selectedTag = Tag::where('slug', $request->tag)->firstOrFail();
        }

        $articles = Article::with(['tags', 'views', 'likes'])
            ->withTag($selectedTag)
            ->latest()
            ->paginate(10);

        $tags = Tag::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->get();

        return view('articles.index', compact('articles', 'tags', 'selectedTag'));
    }

    public function show(Article $article)
    {
        $article->load(['tags', 'comments' => function ($query) {
            $query->whereNull('parent_id')
                  ->with('replies');
        }, 'views', 'likes']);

        return view('articles.show', compact('article'));
    }

    public function incrementViews(Article $article)
    {
        $article->views()->increment('count');

        return response()->json(['success' => true]);
    }
}
