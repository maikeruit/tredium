<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
            'subject' => 'required|string|max:255'
        ]);

        sleep(5);

        $comment = $article->comments()->create($validated);
        $comment->load('replies');

        return response()->json($comment);
    }
}
