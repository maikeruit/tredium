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
        $articles = Article::with(['tags', 'views', 'likes']);
        
        if ($request->has('tag')) {
            $selectedTag = Tag::where('slug', $request->tag)->firstOrFail();
            $articles = $articles->whereHas('tags', function ($query) use ($selectedTag) {
                $query->where('tags.id', $selectedTag->id);
            });
        }
        
        $articles = $articles->latest()->paginate(10);
        
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

        $article->views()->increment('count');

        return view('articles.show', compact('article'));
    }
}
