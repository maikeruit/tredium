<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'count'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
} 