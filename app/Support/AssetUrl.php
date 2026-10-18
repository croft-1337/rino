<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class AssetUrl
{
    public static function resolve(?string $path): ?string
    {
        $path = trim($path ?? '');

        if ($path === '') {
            return null;
        }

        if (
            str_starts_with($path, 'https://') ||
            str_starts_with($path, 'http://') ||
            str_starts_with($path, '//')
        ) {
            return $path;
        }

        if (
            str_starts_with($path, '/storage/') ||
            str_starts_with($path, '/assets/')
        ) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (
            str_starts_with($path, 'assets/') &&
            is_file(public_path($path))
        ) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
