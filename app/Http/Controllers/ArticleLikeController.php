<?php

namespace App\Http\Controllers;

use App\Jobs\IncrementArticleLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class ArticleLikeController extends Controller
{
    public function store(int $id): JsonResponse
    {
        $key = "article:{$id}:likes";
        $count = Redis::incr($key);

        IncrementArticleLike::dispatch($id);

        return response()->json([
            'count' => $count
        ]);
    }
}
