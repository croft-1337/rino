<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogTag extends Model
{
    protected $fillable = [
        'default_key',
        'name',
        'slug',
        'enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'enabled' =>
                'boolean',

            'sort_order' =>
                'integer',
        ];
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            'blog_post_blog_tag'
        );
    }

    public function getIsDefaultContentAttribute(): bool
    {
        return filled(
            $this->default_key
        );
    }
}