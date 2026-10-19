<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    public const TYPE_STRUCTURED = 'structured';

    public const TYPE_DOCUMENT = 'document';

    public const TYPE_EXTERNAL = 'external';

    public const DOCUMENT_LAYOUT_LEFT = 'left';

    public const DOCUMENT_LAYOUT_CENTERED = 'centered';

    protected $fillable = [
        'default_key',

        'category_id',
        'title',
        'slug',
        'template',
        'page_type',
        'short_description',
        'seo_title',
        'seo_description',
        'seo_social_image',
        'content',
        'sections',

        'document_layout',
        'document_updated_at',

        'external_url',
        'open_new_tab',

        'active',
        'show_in_header',
        'show_in_footer',
        'sort_order',

        'published',
        'system_page',
    ];

    protected function casts(): array
    {
        return [
            'sections' =>
                'array',

            'document_updated_at' =>
                'date',

            'open_new_tab' =>
                'boolean',

            'active' =>
                'boolean',

            'show_in_header' =>
                'boolean',

            'show_in_footer' =>
                'boolean',

            'sort_order' =>
                'integer',

            'published' =>
                'boolean',

            'system_page' =>
                'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            PageCategory::class,
            'category_id'
        );
    }

    public function getUrlAttribute(): string
    {
        if (
            $this->page_type ===
            self::TYPE_EXTERNAL
        ) {
            return $this->external_url
                ?: '#';
        }

        return '/'
            .
            ltrim(
                (string) $this->slug,
                '/'
            );
    }

    public function getIsExternalAttribute(): bool
    {
        return $this->page_type ===
            self::TYPE_EXTERNAL;
    }

    public function getIsDocumentAttribute(): bool
    {
        return $this->page_type ===
            self::TYPE_DOCUMENT;
    }

    public function getIsStructuredAttribute(): bool
    {
        return $this->page_type ===
            self::TYPE_STRUCTURED;
    }

    public function getIsDefaultContentAttribute(): bool
    {
        return filled(
            $this->default_key
        );
    }
}
