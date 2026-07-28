<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
        'category',
        'source',
        'metadata',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected static function booted()
    {
        static::saved(function (News $news) {
            app(\App\Services\SemanticService::class)->indexNews($news);
        });

        static::deleted(function (News $news) {
            app(\App\Services\SemanticService::class)->deleteNews($news);
        });
    }
}
