<?php

namespace App\Support\Defaults;

use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Page;
use App\Models\PageCategory;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BlogDefaults
{
    public static function definition(): array
    {
        $file =
            database_path(
                'defaults/blog.php'
            );

        if (
            !file_exists(
                $file
            )
        ) {
            return [];
        }

        $definition =
            require $file;

        return is_array(
            $definition
        )
            ? $definition
            : [];
    }

    public static function seed(): void
    {
        DB::transaction(
            function (): void {
                $definition =
                    self::definition();

                if (!$definition) {
                    return;
                }

                $page =
                    self::seedPage(
                        $definition['page']
                        ?? []
                    );

                self::seedSettings(
                    $definition['settings']
                    ?? [],
                    $page
                );

                $tags =
                    self::seedTags(
                        $definition['tags']
                        ?? []
                    );

                self::seedPosts(
                    $definition['posts']
                    ?? [],
                    $tags
                );
            }
        );
    }

    public static function resetTag(
        BlogTag $tag
    ): BlogTag {
        $key =
            $tag->default_key;

        if (blank($key)) {
            throw new RuntimeException(
                'This blog tag is not linked to Rino default content.'
            );
        }

        $definitions =
            self::definition()['tags']
            ?? [];

        $shortKey =
            str_replace(
                'blog-tag-',
                '',
                $key
            );

        $definition =
            $definitions[$shortKey]
            ?? null;

        if (!$definition) {
            throw new RuntimeException(
                'The default definition for this blog tag could not be found.'
            );
        }

        $tag->fill([
            'name' =>
                $definition['name'],

            'slug' =>
                $definition['slug'],

            'enabled' =>
                $definition['enabled']
                ?? true,

            'sort_order' =>
                $definition['sort_order']
                ?? 0,
        ]);

        $tag->save();

        return $tag;
    }

    public static function resetPost(
        BlogPost $post
    ): BlogPost {
        $key =
            $post->default_key;

        if (blank($key)) {
            throw new RuntimeException(
                'This blog post is not linked to Rino default content.'
            );
        }

        $definitions =
            self::definition()['posts']
            ?? [];

        $shortKey =
            str_replace(
                'blog-post-',
                '',
                $key
            );

        $definition =
            $definitions[$shortKey]
            ?? null;

        if (!$definition) {
            throw new RuntimeException(
                'The default definition for this blog post could not be found.'
            );
        }

        $post->fill(
            self::postValues(
                $definition
            )
        );

        $post->save();

        $tagIds =
            collect(
                $definition['tags']
                ?? []
            )
                ->map(
                    fn (string $tagKey) =>
                        BlogTag::query()
                            ->where(
                                'default_key',
                                'blog-tag-' . $tagKey
                            )
                            ->value('id')
                )
                ->filter()
                ->values()
                ->all();

        $post
            ->tags()
            ->sync(
                $tagIds
            );

        return $post;
    }

    private static function seedPage(
        array $definition
    ): Page {
        $key =
            $definition['default_key']
            ?? 'blog';

        $categoryId =
            self::resolvePageCategoryId(
                $definition
            );

        $page =
            Page::query()
                ->where(
                    'default_key',
                    $key
                )
                ->first();

        if ($page) {
            $page->category_id =
                $categoryId;

            $page->save();

            return $page->fresh();
        }

        $page =
            Page::query()
                ->where(
                    'template',
                    'blog'
                )
                ->first();

        if (!$page) {
            $page =
                Page::query()
                    ->where(
                        'slug',
                        $definition['slug']
                        ?? 'blog'
                    )
                    ->first();
        }

        if ($page) {
            if (
                filled(
                    $page->default_key
                )
                &&
                $page->default_key
                    !== $key
            ) {
                throw new RuntimeException(
                    'The existing Blog page is already linked to another default.'
                );
            }

            $page->default_key =
                $key;

            $page->category_id =
                $categoryId;

            $page->save();

            return $page->fresh();
        }

        return Page::query()
            ->create([
                'default_key' =>
                    $key,

                'category_id' =>
                    $categoryId,

                'title' =>
                    $definition['title']
                    ?? 'Blog',

                'slug' =>
                    $definition['slug']
                    ?? 'blog',

                'template' =>
                    'blog',

                'page_type' =>
                    Page::TYPE_STRUCTURED,

                'short_description' =>
                    $definition['short_description']
                    ?? null,

                'sections' =>
                    [],

                'active' =>
                    $definition['active']
                    ?? true,

                'show_in_header' =>
                    $definition['show_in_header']
                    ?? false,

                'show_in_footer' =>
                    $definition['show_in_footer']
                    ?? false,

                'sort_order' =>
                    $definition['sort_order']
                    ?? 100,

                'published' =>
                    $definition['published']
                    ?? true,

                'system_page' =>
                    $definition['system_page']
                    ?? false,
            ]);
    }

    private static function resolvePageCategoryId(
        array $definition
    ): ?int {
        $categoryKey =
            $definition['category']
            ?? null;

        if (!$categoryKey) {
            return null;
        }

        $categoryDefinition =
            DefaultContent::categories()[
                $categoryKey
            ]
            ?? null;

        if (!$categoryDefinition) {
            throw new RuntimeException(
                'Page category "'
                .
                $categoryKey
                .
                '" is not defined in database/defaults/categories.php.'
            );
        }

        $category =
            PageCategory::query()
                ->firstOrCreate(
                    [
                        'name' =>
                            $categoryDefinition['name'],
                    ],
                    [
                        'sort_order' =>
                            $categoryDefinition['sort_order']
                            ?? 0,
                    ]
                );

        return $category->id;
    }

    private static function seedSettings(
        array $settings,
        Page $page
    ): void {
        foreach (
            $settings
            as $key => $definition
        ) {
            Setting::query()
                ->firstOrCreate(
                    [
                        'key' =>
                            $key,
                    ],
                    [
                        'value' =>
                            $definition['value']
                            ?? '',

                        'type' =>
                            $definition['type']
                            ?? 'text',

                        'group' =>
                            'blog',
                    ]
                );
        }

        Setting::query()
            ->firstOrCreate(
                [
                    'key' =>
                        'blog_page_id',
                ],
                [
                    'value' =>
                        (string) $page->id,

                    'type' =>
                        'number',

                    'group' =>
                        'blog',
                ]
            );
    }

    private static function seedTags(
        array $definitions
    ): array {
        $tags = [];

        foreach (
            $definitions
            as $key => $definition
        ) {
            $defaultKey =
                'blog-tag-' . $key;

            $tag =
                BlogTag::query()
                    ->where(
                        'default_key',
                        $defaultKey
                    )
                    ->first();

            if (!$tag) {
                $tag =
                    BlogTag::query()
                        ->where(
                            'slug',
                            $definition['slug']
                        )
                        ->first();
            }

            if ($tag) {
                if (
                    filled(
                        $tag->default_key
                    )
                    &&
                    $tag->default_key
                        !== $defaultKey
                ) {
                    throw new RuntimeException(
                        'Blog tag "'
                        .
                        $definition['slug']
                        .
                        '" is already linked to another default.'
                    );
                }

                if (
                    blank(
                        $tag->default_key
                    )
                ) {
                    $tag->default_key =
                        $defaultKey;

                    $tag->save();
                }
            } else {
                $tag =
                    BlogTag::query()
                        ->create([
                            'default_key' =>
                                $defaultKey,

                            'name' =>
                                $definition['name'],

                            'slug' =>
                                $definition['slug'],

                            'enabled' =>
                                $definition['enabled']
                                ?? true,

                            'sort_order' =>
                                $definition['sort_order']
                                ?? 0,
                        ]);
            }

            $tags[$key] =
                $tag;
        }

        return $tags;
    }

    private static function seedPosts(
        array $definitions,
        array $tags
    ): void {
        foreach (
            $definitions
            as $key => $definition
        ) {
            $defaultKey =
                'blog-post-' . $key;

            $post =
                BlogPost::query()
                    ->where(
                        'default_key',
                        $defaultKey
                    )
                    ->first();

            if (!$post) {
                $post =
                    BlogPost::query()
                        ->where(
                            'slug',
                            $definition['slug']
                        )
                        ->first();
            }

            $created =
                false;

            if ($post) {
                if (
                    filled(
                        $post->default_key
                    )
                    &&
                    $post->default_key
                        !== $defaultKey
                ) {
                    throw new RuntimeException(
                        'Blog post "'
                        .
                        $definition['slug']
                        .
                        '" is already linked to another default.'
                    );
                }

                if (
                    blank(
                        $post->default_key
                    )
                ) {
                    $post->default_key =
                        $defaultKey;

                    $post->save();
                }
            } else {
                $post =
                    BlogPost::query()
                        ->create(
                            array_merge(
                                [
                                    'default_key' =>
                                        $defaultKey,
                                ],
                                self::postValues(
                                    $definition
                                )
                            )
                        );

                $created =
                    true;
            }

            if ($created) {
                $tagIds =
                    collect(
                        $definition['tags']
                        ?? []
                    )
                        ->map(
                            fn (string $tagKey) =>
                                $tags[$tagKey]?->id
                                ?? null
                        )
                        ->filter()
                        ->values()
                        ->all();

                $post
                    ->tags()
                    ->sync(
                        $tagIds
                    );
            }
        }
    }

    private static function postValues(
        array $definition
    ): array {
        return [
            'title' =>
                $definition['title'],

            'slug' =>
                $definition['slug'],

            'excerpt' =>
                $definition['excerpt']
                ?? null,

            'content' =>
                $definition['content']
                ?? '',

            'featured_image' =>
                $definition['featured_image']
                ?? null,

            'author' =>
                $definition['author']
                ?? null,

            'published_date' =>
                $definition['published_date']
                ?? null,

            'read_time' =>
                $definition['read_time']
                ?? 5,

            'published' =>
                $definition['published']
                ?? false,

            'seo_title' =>
                $definition['seo_title']
                ?? null,

            'seo_description' =>
                $definition['seo_description']
                ?? null,
        ];
    }
}
