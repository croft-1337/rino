<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'default_key',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author',
        'published_date',
        'read_time',
        'published',
        'seo_title',
        'seo_description',
        'seo_social_image',
    ];

    protected function casts(): array
    {
        return [
            'published' =>
                'boolean',

            'published_date' =>
                'date',

            'read_time' =>
                'integer',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_post_blog_tag'
        );
    }

    public function scopePublished(
        Builder $query
    ): Builder {
        return $query
            ->where(
                'published',
                true
            )
            ->where(
                function (
                    Builder $query
                ): void {
                    $query
                        ->whereNull(
                            'published_date'
                        )
                        ->orWhereDate(
                            'published_date',
                            '<=',
                            now()
                                ->toDateString()
                        );
                }
            );
    }

    public function getUrlAttribute(): string
    {
        $blogSlug =
            Str::slug(
                (string) (
                    Setting::query()
                        ->where(
                            'key',
                            'blog_slug'
                        )
                        ->value(
                            'value'
                        )
                    ?: 'blog'
                )
            );

        if (!$blogSlug) {
            $blogSlug =
                'blog';
        }

        return '/'
            .
            $blogSlug
            .
            '/'
            .
            ltrim(
                $this->slug,
                '/'
            );
    }

    public function getIsDefaultContentAttribute(): bool
    {
        return filled(
            $this->default_key
        );
    }
}
