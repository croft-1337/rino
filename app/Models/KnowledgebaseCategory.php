<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgebaseCategory extends Model
{
    protected $fillable = [
        'default_key',
        'name',
        'slug',
        'description',
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

    public function articles(): HasMany
    {
        return $this->hasMany(
            KnowledgebaseArticle::class,
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