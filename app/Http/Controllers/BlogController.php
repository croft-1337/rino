<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Page;
use App\Models\Setting;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(
        Request $request
    ): View {
        $selectedTag =
            trim(
                (string) $request->query(
                    'tag',
                    'all'
                )
            );

        $search =
            trim(
                (string) $request->query(
                    'q',
                    ''
                )
            );

        $posts =
            BlogPost::query()
                ->published()
                ->with([
                    'tags',
                ])
                ->when(
                    $selectedTag !== 'all',
                    function (
                        $query
                    ) use (
                        $selectedTag
                    ): void {
                        $query->whereHas(
                            'tags',
                            fn ($tagQuery) =>
                                $tagQuery
                                    ->where(
                                        'slug',
                                        $selectedTag
                                    )
                                    ->where(
                                        'enabled',
                                        true
                                    )
                        );
                    }
                )
                ->when(
                    $search !== '',
                    function (
                        $query
                    ) use (
                        $search
                    ): void {
                        $query->where(
                            function (
                                $query
                            ) use (
                                $search
                            ): void {
                                $query
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'excerpt',
                                        'like',
                                        '%' . $search . '%'
                                    );
                            }
                        );
                    }
                )
                ->orderByDesc(
                    'published_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->paginate(
                    9
                )
                ->withQueryString();

        $tags =
            BlogTag::query()
                ->where(
                    'enabled',
                    true
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'name'
                )
                ->get();

        $blog =
            $this->blogData();

        return view(
            'blog.index',
            array_merge(
                SiteData::get(),
                [
                    'posts' =>
                        $posts,

                    'tags' =>
                        $tags,

                    'selectedTag' =>
                        $selectedTag,

                    'search' =>
                        $search,

                    'blog' =>
                        $blog,
                ]
            )
        );
    }

    public function show(
        string $slug
    ): View {
        $post =
            BlogPost::query()
                ->published()
                ->with([
                    'tags',
                ])
                ->where(
                    'slug',
                    $slug
                )
                ->firstOrFail();

        $blog =
            $this->blogData();

        return view(
            'blog.show',
            array_merge(
                SiteData::get(),
                [
                    'post' =>
                        $post,

                    'blog' =>
                        $blog,
                ]
            )
        );
    }

    private function blogData(): array
    {
        $settings =
            Setting::query()
                ->where(
                    'group',
                    'blog'
                )
                ->pluck(
                    'value',
                    'key'
                );

        $configuredSlug =
            Str::slug(
                (string) $settings->get(
                    'blog_slug',
                    'blog'
                )
            );

        if (!$configuredSlug) {
            $configuredSlug =
                'blog';
        }

        $blogPage =
            null;

        $pageId =
            $settings->get(
                'blog_page_id'
            );

        if (
            filled(
                $pageId
            )
        ) {
            $blogPage =
                Page::query()
                    ->find(
                        (int) $pageId
                    );
        }

        if (!$blogPage) {
            $blogPage =
                Page::query()
                    ->where(
                        'template',
                        'blog'
                    )
                    ->first();
        }

        if (!$blogPage) {
            $blogPage =
                Page::query()
                    ->where(
                        'slug',
                        $configuredSlug
                    )
                    ->first();
        }

        $heroImage =
            $settings->get(
                'blog_hero_background_image'
            );

        if (
            filled(
                $heroImage
            )
        ) {
            $heroImage =
                ltrim(
                    $heroImage,
                    '/'
                );

            $heroImage =
                Str::startsWith(
                    $heroImage,
                    ['http://', 'https://']
                )
                    ? $heroImage
                    : (
                        Str::startsWith(
                            $heroImage,
                            'assets/'
                        )
                            ? asset($heroImage)
                            : Storage::disk('public')->url($heroImage)
                    );
        } else {
            $heroImage =
                null;
        }

        return [
            'title' =>
                $settings->get(
                    'blog_page_title'
                )
                ?: $blogPage?->title
                ?: 'Blog',

            'slug' =>
                $settings->get(
                    'blog_slug'
                )
                ?: $blogPage?->slug
                ?: 'blog',

            'description' =>
                $settings->get(
                    'blog_description'
                )
                ?: $blogPage?->short_description
                ?: '',

            'hero_enabled' =>
                $this->boolean(
                    $settings->get(
                        'blog_hero_enabled',
                        true
                    )
                ),

            'hero_eyebrow' =>
                $settings->get(
                    'blog_hero_eyebrow'
                )
                ?: 'Resources',

            'hero_heading' =>
                $settings->get(
                    'blog_hero_heading'
                )
                ?: 'Insights, guides & updates',

            'hero_description' =>
                $settings->get(
                    'blog_hero_description'
                )
                ?: '',

            'hero_background_image' =>
                $heroImage,

            'hero_alignment' =>
                $settings->get(
                    'blog_hero_alignment',
                    'left'
                )
                ?: 'left',

            'seo_title' =>
                $settings->get(
                    'blog_seo_title'
                )
                ?: '',

            'seo_description' =>
                $settings->get(
                    'blog_seo_description'
                )
                ?: '',
        ];
    }

    private function boolean(
        mixed $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
