<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public static function getCachedWithArticlesCount()
    {
        return Cache::tags(['tags'])->remember(
            'tags.with.articles.count',
            3600,
            fn() => static::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->get()
        );
    }
}
