<?php

namespace App\Support\Defaults;

use App\Models\Page;
use App\Models\PageCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DefaultContent
{
    public static function categories(): array
    {
        $file =
            database_path(
                'defaults/categories.php'
            );

        if (
            !file_exists(
                $file
            )
        ) {
            return [];
        }

        $categories =
            require $file;

        return is_array(
            $categories
        )
            ? $categories
            : [];
    }

    public static function all(): array
    {
        return array_merge(
            self::loadDirectory(
                database_path(
                    'defaults/structured'
                )
            ),
            self::loadDirectory(
                database_path(
                    'defaults/documents'
                )
            )
        );
    }

    public static function find(
        string $key
    ): ?array {
        $defaults =
            self::all();

        return $defaults[
            $key
        ]
            ?? null;
    }

    public static function exists(
        string $key
    ): bool {
        return self::find(
            $key
        ) !== null;
    }

    public static function seed(): void
    {
        DB::transaction(
            function (): void {
                $categories =
                    self::seedCategories();

                foreach (
                    self::all()
                    as $key => $definition
                ) {
                    self::seedPage(
                        $key,
                        $definition,
                        $categories
                    );
                }
            }
        );
    }

    public static function reset(
        Page $page
    ): Page {
        if (
            blank(
                $page->default_key
            )
        ) {
            throw new RuntimeException(
                'This page is not linked to Rino default content.'
            );
        }

        $definition =
            self::find(
                $page->default_key
            );

        if (!$definition) {
            throw new RuntimeException(
                'The default definition for this page could not be found.'
            );
        }

        $pageType =
            $definition[
                'page_type'
            ]
            ?? Page::TYPE_STRUCTURED;

        $values = [
            'title' =>
                $definition[
                    'title'
                ]
                ?? $page->title,

            'short_description' =>
                $definition[
                    'short_description'
                ]
                ?? null,

            'template' =>
                $definition[
                    'template'
                ]
                ?? 'standard',

            'page_type' =>
                $pageType,

            'system_page' =>
                (bool) (
                    $definition[
                        'system_page'
                    ]
                    ?? false
                ),
        ];

        if (
            $pageType ===
            Page::TYPE_STRUCTURED
        ) {
            $values[
                'sections'
            ] =
                $definition[
                    'sections'
                ]
                ?? [];

            $values[
                'content'
            ] =
                null;
        }

        if (
            $pageType ===
            Page::TYPE_DOCUMENT
        ) {
            $values[
                'content'
            ] =
                $definition[
                    'content'
                ]
                ?? '';

            $values[
                'document_layout'
            ] =
                $definition[
                    'document_layout'
                ]
                ?? Page::DOCUMENT_LAYOUT_LEFT;

            $values[
                'document_updated_at'
            ] =
                $definition[
                    'document_updated_at'
                ]
                ?? null;

            $values[
                'sections'
            ] =
                null;
        }

        $page->update(
            $values
        );

        return $page->fresh();
    }

    private static function seedCategories(): Collection
    {
        $result =
            collect();

        foreach (
            self::categories()
            as $key => $definition
        ) {
            $category =
                PageCategory::query()
                    ->firstOrCreate(
                        [
                            'name' =>
                                $definition[
                                    'name'
                                ],
                        ],
                        [
                            'sort_order' =>
                                $definition[
                                    'sort_order'
                                ]
                                ?? 0,
                        ]
                    );

            $result->put(
                $key,
                $category
            );
        }

        return $result;
    }

    private static function seedPage(
        string $key,
        array $definition,
        Collection $categories
    ): Page {
        $existingDefault =
            Page::query()
                ->where(
                    'default_key',
                    $key
                )
                ->first();

        if ($existingDefault) {
            $systemPage =
                (bool) (
                    $definition[
                        'system_page'
                    ]
                    ?? false
                );

            if (
                $existingDefault
                    ->system_page
                !==
                $systemPage
            ) {
                $existingDefault
                    ->system_page =
                    $systemPage;

                $existingDefault
                    ->save();
            }

            return $existingDefault
                ->fresh();
        }

        $slug =
            $definition[
                'slug'
            ]
            ?? $key;

        $existingSlug =
            Page::query()
                ->where(
                    'slug',
                    $slug
                )
                ->first();

        if ($existingSlug) {
            if (
                filled(
                    $existingSlug
                        ->default_key
                )
                &&
                $existingSlug
                    ->default_key
                !==
                $key
            ) {
                throw new RuntimeException(
                    'The slug "'
                    . $slug
                    . '" is already linked to another default page.'
                );
            }

            $existingSlug
                ->default_key =
                $key;

            $existingSlug
                ->system_page =
                (bool) (
                    $definition[
                        'system_page'
                    ]
                    ?? false
                );

            $existingSlug
                ->save();

            return $existingSlug
                ->fresh();
        }

        $categoryId =
            null;

        $categoryKey =
            $definition[
                'category'
            ]
            ?? null;

        if (
            $categoryKey
            &&
            $categories->has(
                $categoryKey
            )
        ) {
            $categoryId =
                $categories
                    ->get(
                        $categoryKey
                    )
                    ->id;
        }

        $page =
            new Page();

        $page->fill([
            'default_key' =>
                $key,

            'slug' =>
                $slug,

            'category_id' =>
                $categoryId,

            'title' =>
                $definition[
                    'title'
                ]
                ?? $key,

            'template' =>
                $definition[
                    'template'
                ]
                ?? 'standard',

            'page_type' =>
                $definition[
                    'page_type'
                ]
                ?? Page::TYPE_STRUCTURED,

            'short_description' =>
                $definition[
                    'short_description'
                ]
                ?? null,

            'content' =>
                $definition[
                    'content'
                ]
                ?? null,

            'sections' =>
                $definition[
                    'sections'
                ]
                ?? null,

            'document_layout' =>
                $definition[
                    'document_layout'
                ]
                ?? Page::DOCUMENT_LAYOUT_LEFT,

            'document_updated_at' =>
                $definition[
                    'document_updated_at'
                ]
                ?? null,

            'active' =>
                $definition[
                    'active'
                ]
                ?? true,

            'show_in_header' =>
                $definition[
                    'show_in_header'
                ]
                ?? false,

            'show_in_footer' =>
                $definition[
                    'show_in_footer'
                ]
                ?? false,

            'sort_order' =>
                $definition[
                    'sort_order'
                ]
                ?? 0,

            'published' =>
                $definition[
                    'published'
                ]
                ?? true,

            'system_page' =>
                (bool) (
                    $definition[
                        'system_page'
                    ]
                    ?? false
                ),
        ]);

        $page->save();

        return $page;
    }

    private static function loadDirectory(
        string $directory
    ): array {
        if (
            !is_dir(
                $directory
            )
        ) {
            return [];
        }

        $defaults = [];

        $files =
            glob(
                $directory
                .
                DIRECTORY_SEPARATOR
                .
                '*.php'
            )
            ?: [];

        foreach (
            $files
            as $file
        ) {
            $definition =
                require $file;

            if (
                !is_array(
                    $definition
                )
            ) {
                continue;
            }

            $key =
                pathinfo(
                    $file,
                    PATHINFO_FILENAME
                );

            $defaults[
                $key
            ] =
                $definition;
        }

        return $defaults;
    }
}