<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'show_in_header',
        'show_in_footer',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'show_in_header' => 'boolean',
            'show_in_footer' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (SocialLink $socialLink): void {
            if ($socialLink->sort_order === 0) {
                $socialLink->sort_order =
                    ((int) static::query()->max('sort_order')) + 1;
            }
        });
    }
}