<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::with(['views', 'likes'])
            ->latest()
            ->paginate(6);

        return view('home', compact('articles'));
    }
} 