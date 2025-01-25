<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
} 