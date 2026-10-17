<?php

namespace App\Support\Defaults;

use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use App\Models\Page;
use App\Models\PageCategory;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class KnowledgebaseDefaults
{
    public static function definition(): array
    {
        $file =
            database_path(
                'defaults/knowledgebase.php'
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

                $categories =
                    self::seedCategories(
                        $definition['categories']
                        ?? []
                    );

                self::seedArticles(
                    $definition['articles']
                    ?? [],
                    $categories
                );
            }
        );
    }

    public static function resetCategory(
        KnowledgebaseCategory $category
    ): KnowledgebaseCategory {
        $key =
            $category->default_key;

        if (blank($key)) {
            throw new RuntimeException(
                'This knowledge base category is not linked to Rino default content.'
            );
        }

        $shortKey =
            str_replace(
                'kb-category-',
                '',
                $key
            );

        $definition =
            self::definition()[
                'categories'
            ][$shortKey]
            ?? null;

        if (!$definition) {
            throw new RuntimeException(
                'The default knowledge base category definition could not be found.'
            );
        }

        $category->fill([
            'name' =>
                $definition['name'],

            'slug' =>
                $definition['slug'],

            'description' =>
                $definition['description']
                ?? null,

            'active' =>
                $definition['active']
                ?? true,

            'sort_order' =>
                $definition['sort_order']
                ?? 0,
        ]);

        $category->save();

        return $category;
    }

    public static function resetArticle(
        KnowledgebaseArticle $article
    ): KnowledgebaseArticle {
        $key =
            $article->default_key;

        if (blank($key)) {
            throw new RuntimeException(
                'This knowledge base article is not linked to Rino default content.'
            );
        }

        $shortKey =
            str_replace(
                'kb-article-',
                '',
                $key
            );

        $definition =
            self::definition()[
                'articles'
            ][$shortKey]
            ?? null;

        if (!$definition) {
            throw new RuntimeException(
                'The default knowledge base article definition could not be found.'
            );
        }

        $category =
            KnowledgebaseCategory::query()
                ->where(
                    'default_key',
                    'kb-category-'
                    .
                    $definition['category']
                )
                ->firstOrFail();

        $article->fill(
            self::articleValues(
                $definition,
                $category
            )
        );

        $article->save();

        return $article;
    }

    private static function seedPage(
        array $definition
    ): Page {
        $key =
            $definition['default_key']
            ?? 'knowledgebase';

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
                    'knowledgebase'
                )
                ->first();

        if (!$page) {
            $page =
                Page::query()
                    ->where(
                        'slug',
                        $definition['slug']
                        ?? 'knowledgebase'
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
                    'The existing Knowledge Base page is already linked to another default.'
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
                    ?? 'Knowledge Base',

                'slug' =>
                    $definition['slug']
                    ?? 'knowledgebase',

                'template' =>
                    'knowledgebase',

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
                    ?? 110,

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
                            'knowledgebase',
                    ]
                );
        }

        Setting::query()
            ->firstOrCreate(
                [
                    'key' =>
                        'knowledgebase_page_id',
                ],
                [
                    'value' =>
                        (string) $page->id,

                    'type' =>
                        'number',

                    'group' =>
                        'knowledgebase',
                ]
            );
    }

    private static function seedCategories(
        array $definitions
    ): array {
        $categories = [];

        foreach (
            $definitions
            as $key => $definition
        ) {
            $defaultKey =
                'kb-category-' . $key;

            $category =
                KnowledgebaseCategory::query()
                    ->where(
                        'default_key',
                        $defaultKey
                    )
                    ->first();

            if (!$category) {
                $category =
                    KnowledgebaseCategory::query()
                        ->where(
                            'slug',
                            $definition['slug']
                        )
                        ->first();
            }

            if ($category) {
                if (
                    filled(
                        $category->default_key
                    )
                    &&
                    $category->default_key
                        !== $defaultKey
                ) {
                    throw new RuntimeException(
                        'Knowledge Base category "'
                        .
                        $definition['slug']
                        .
                        '" is already linked to another default.'
                    );
                }

                if (
                    blank(
                        $category->default_key
                    )
                ) {
                    $category->default_key =
                        $defaultKey;

                    $category->save();
                }
            } else {
                $category =
                    KnowledgebaseCategory::query()
                        ->create([
                            'default_key' =>
                                $defaultKey,

                            'name' =>
                                $definition['name'],

                            'slug' =>
                                $definition['slug'],

                            'description' =>
                                $definition['description']
                                ?? null,

                            'active' =>
                                $definition['active']
                                ?? true,

                            'sort_order' =>
                                $definition['sort_order']
                                ?? 0,
                        ]);
            }

            $categories[$key] =
                $category;
        }

        return $categories;
    }

    private static function seedArticles(
        array $definitions,
        array $categories
    ): void {
        foreach (
            $definitions
            as $key => $definition
        ) {
            $defaultKey =
                'kb-article-' . $key;

            $article =
                KnowledgebaseArticle::query()
                    ->where(
                        'default_key',
                        $defaultKey
                    )
                    ->first();

            if (!$article) {
                $article =
                    KnowledgebaseArticle::query()
                        ->where(
                            'slug',
                            $definition['slug']
                        )
                        ->first();
            }

            $category =
                $categories[
                    $definition['category']
                ]
                ?? null;

            if (!$category) {
                throw new RuntimeException(
                    'Knowledge Base category for article "'
                    .
                    $definition['slug']
                    .
                    '" could not be found.'
                );
            }

            if ($article) {
                if (
                    filled(
                        $article->default_key
                    )
                    &&
                    $article->default_key
                        !== $defaultKey
                ) {
                    throw new RuntimeException(
                        'Knowledge Base article "'
                        .
                        $definition['slug']
                        .
                        '" is already linked to another default.'
                    );
                }

                if (
                    blank(
                        $article->default_key
                    )
                ) {
                    $article->default_key =
                        $defaultKey;

                    $article->save();
                }

                continue;
            }

            KnowledgebaseArticle::query()
                ->create(
                    array_merge(
                        [
                            'default_key' =>
                                $defaultKey,
                        ],
                        self::articleValues(
                            $definition,
                            $category
                        )
                    )
                );
        }
    }

    private static function articleValues(
        array $definition,
        KnowledgebaseCategory $category
    ): array {
        return [
            'knowledgebase_category_id' =>
                $category->id,

            'title' =>
                $definition['title'],

            'slug' =>
                $definition['slug'],

            'short_description' =>
                $definition['short_description']
                ?? null,

            'content' =>
                $definition['content']
                ?? '',

            'active' =>
                $definition['active']
                ?? true,

            'sort_order' =>
                $definition['sort_order']
                ?? 0,
        ];
    }
}
