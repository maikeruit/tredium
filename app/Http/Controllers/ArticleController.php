<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Jobs\IncrementArticleViews;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $selectedTag = null;

        if ($request->has('tag')) {
            $selectedTag = Tag::where('slug', $request->tag)->firstOrFail();
        }

        $articles = Article::getCachedByTag($selectedTag);
        $tags = Tag::getCachedWithArticlesCount();

        return view('articles.index', compact('articles', 'tags', 'selectedTag'));
    }

    public function show(int $id)
    {
        $article = Article::getCachedArticle($id);

        return view('articles.show', compact('article'));
    }

    public function incrementViews(int $id)
    {
        $key = "article:{$id}:views";
        Redis::incr($key);

        IncrementArticleViews::dispatch($id);

        Cache::tags(['articles'])->forget("article.{$id}");

        return response()->json(['success' => true]);
    }
}
