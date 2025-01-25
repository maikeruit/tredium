<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleLikeController extends Controller
{
    public function store(Article $article): JsonResponse
    {
        $article->likes()->increment('count');
        
        return response()->json([
            'count' => $article->likes->count
        ]);
    }
} 