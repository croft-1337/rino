<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgebaseArticle extends Model
{
    protected $fillable = [
        'default_key',
        'knowledgebase_category_id',
        'title',
        'slug',
        'short_description',
        'seo_title',
        'seo_description',
        'seo_social_image',
        'content',
        'active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'active' =>
                'boolean',

            'sort_order' =>
                'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            KnowledgebaseCategory::class,
            'knowledgebase_category_id'
        );
    }

    public function getIsDefaultContentAttribute(): bool
    {
        return filled(
            $this->default_key
        );
    }
}
