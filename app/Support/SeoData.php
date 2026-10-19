<?php

namespace App\Support;

use App\Models\BlogPost;
use App\Models\KnowledgebaseArticle;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class SeoData
{
    public static function resolve(array $data, string $fallbackTitle): array
    {
        $settings = $data['seoSettings'] ?? [];
        $siteName = trim((string) ($data['siteName'] ?? 'Rino'));
        $title = trim($fallbackTitle);
        $description = trim((string) ($settings['description'] ?? ''));
        $image = $settings['social_image'] ?? null;
        $type = 'website';

        $page = $data['page'] ?? null;
        $post = $data['post'] ?? null;
        $article = $data['article'] ?? null;

        $path = request()->path();

        if ($path === 'blog' && isset($data['blog']) && is_array($data['blog'])) {
            $blog = $data['blog'];

            $title = self::title(
                $blog['seo_title'] ?? null,
                self::first($blog['title'] ?? null, 'Blog').' | '.$siteName,
                $siteName
            );

            $description = self::first(
                $blog['seo_description'] ?? null,
                $description
            );
        } elseif ($path === 'knowledgebase' && isset($data['knowledgebase']) && is_array($data['knowledgebase'])) {
            $knowledgebase = $data['knowledgebase'];

            $title = self::title(
                $knowledgebase['seo_title'] ?? null,
                self::first($knowledgebase['title'] ?? null, 'Knowledgebase').' | '.$siteName,
                $siteName
            );

            $description = self::first(
                $knowledgebase['seo_description'] ?? null,
                $description
            );
        } elseif ($page instanceof Page) {
            $title = self::title(
                $page->seo_title,
                $title,
                $siteName
            );

            $description = self::first(
                $page->seo_description,
                $page->short_description,
                $description
            );

            $image = $page->seo_social_image ?: $image;
        } elseif ($post instanceof BlogPost) {
            $title = self::title(
                $post->seo_title,
                $title,
                $siteName
            );

            $description = self::first(
                $post->seo_description,
                $post->excerpt,
                $description
            );

            $image = $post->seo_social_image ?: $post->featured_image ?: $image;
            $type = 'article';
        } elseif ($article instanceof KnowledgebaseArticle) {
            $title = self::title(
                $article->seo_title,
                $title,
                $siteName
            );

            $description = self::first(
                $article->seo_description,
                $article->short_description,
                $description
            );

            $image = $article->seo_social_image ?: $image;
            $type = 'article';
        }

        if ($path === '/') {
            $title = self::first(
                $settings['default_title'] ?? null,
                $title,
                $siteName
            );
        }

        $robots = $settings['robots'] ?? 'index,follow';

        if (!in_array($robots, ['index,follow', 'noindex,follow', 'noindex,nofollow'], true)) {
            $robots = 'index,follow';
        }

        $canonical = url()->current();
        $imageUrl = self::imageUrl($image);

        $twitter = ltrim(
            trim((string) ($settings['twitter_username'] ?? '')),
            '@'
        );

        $twitter = preg_match('/^[a-zA-Z0-9_]{1,15}$/', $twitter)
            ? '@'.$twitter
            : null;

        $card = ($settings['twitter_card'] ?? null) === 'summary'
            ? 'summary'
            : 'summary_large_image';

        return compact(
            'title',
            'description',
            'robots',
            'canonical',
            'imageUrl',
            'twitter',
            'card',
            'type'
        ) + [
            'siteName' => $siteName,
            'company' => trim((string) ($settings['company'] ?? '')),
        ];
    }

    private static function first(?string ...$values): string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return trim($value);
            }
        }

        return '';
    }

    private static function title(
        ?string $custom,
        string $fallback,
        string $siteName
    ): string {
        if (!filled($custom)) {
            return $fallback;
        }

        $custom = trim($custom);

        return str_contains(
            mb_strtolower($custom),
            mb_strtolower($siteName)
        )
            ? $custom
            : $custom.' | '.$siteName;
    }

    private static function imageUrl(?string $image): ?string
    {
        if (!filled($image)) {
            return null;
        }

        if (preg_match('~^https?://~i', $image)) {
            return $image;
        }

        if (
            str_starts_with($image, '/assets/')
            || str_starts_with($image, 'assets/')
        ) {
            return asset(ltrim($image, '/'));
        }

        return url(
            Storage::disk('public')->url(ltrim($image, '/'))
        );
    }
}
