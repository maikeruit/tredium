<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_image',
        'content'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasOne
    {
        return $this->hasOne(Like::class);
    }

    public function views(): HasOne
    {
        return $this->hasOne(View::class);
    }

    /**
     * Scope для фильтрации статей по тегу
     */
    public function scopeWithTag($query, ?Tag $tag)
    {
        if ($tag) {
            return $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            });
        }

        return $query;
    }

    public function getLikesCountAttribute()
    {
        $redisKey = "article:{$this->id}:likes";

        $redisCount = Redis::get($redisKey);

        if ($redisCount !== null) {
            return (int) $redisCount;
        }

        $dbCount = $this->likes->count ?? 0;

        Redis::set($redisKey, $dbCount);

        return $dbCount;
    }

    public function getViewsCountAttribute()
    {
        $redisKey = "article:{$this->id}:views";

        $redisCount = Redis::get($redisKey);

        if ($redisCount !== null) {
            return (int) $redisCount;
        }

        $dbCount = $this->views->count ?? 0;

        Redis::set($redisKey, $dbCount);

        return $dbCount;
    }

    public function getCachedCommentsAttribute()
    {
        return Cache::tags(['article_comments'])->remember(
            "article.{$this->id}.comments",
            3600,
            fn() => $this->comments()->whereNull('parent_id')->with('replies')->get()
        );
    }

    public static function getCachedLatest($perPage = 10)
    {
        $page = request()->get('page', 1);

        return Cache::tags(['articles'])->remember(
            "articles.latest.{$page}.{$perPage}",
            3600,
            fn() => static::with(['tags'])
                ->latest()
                ->paginate($perPage)
        );
    }

    public static function getCachedByTag(?Tag $tag, $perPage = 10)
    {
        if (!$tag) {
            return static::getCachedLatest($perPage);
        }

        $page = request()->get('page', 1);

        return Cache::tags(['articles', "tag.{$tag->id}"])->remember(
            "articles.tag.{$tag->id}.{$page}.{$perPage}",
            3600,
            fn() => static::with(['tags'])
                ->withTag($tag)
                ->latest()
                ->paginate($perPage)
        );
    }

    public static function getCachedArticle($id)
    {
        return Cache::tags(['articles'])->remember(
            "article.{$id}",
            3600,
            fn() => static::with(['tags'])
                ->findOrFail($id)
        );
    }
}
