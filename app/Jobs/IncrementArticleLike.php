<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class IncrementArticleLike implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly Article $article
    )
    {
        $this->onQueue('likes');
    }

    public function handle(): void
    {
        $key = "article:{$this->article->id}:likes";

        Article::find($this->article->id)
            ->likes()->update([
                'count' => Redis::get($key)
            ]);
    }
}
