<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Jobs\IncrementArticleViews;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $selectedTag = null;

        if ($request->has('tag')) {
            $selectedTag = Tag::where('slug', $request->tag)->firstOrFail();
        }

        $articles = Article::with(['tags'])
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
        $article->load(['tags']);

        return view('articles.show', compact('article'));
    }

    public function incrementViews(Article $article)
    {
        $key = "article:{$article->id}:likes";
        Redis::incr($key);

        IncrementArticleViews::dispatch($article);

        return response()->json(['success' => true]);
    }
}
