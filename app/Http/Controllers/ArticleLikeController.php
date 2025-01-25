<?php

namespace App\Http\Controllers;

use App\Jobs\IncrementArticleLike;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class ArticleLikeController extends Controller
{
    public function store(Article $article): JsonResponse
    {
        $key = "article:{$article->id}:likes";
        $count = Redis::incr($key);

        IncrementArticleLike::dispatch($article);

        return response()->json([
            'count' => $count
        ]);
    }
}
