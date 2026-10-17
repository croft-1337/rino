<?php

namespace App\Http\Controllers;

use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use App\Models\Page;
use App\Models\Setting;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KnowledgebaseController extends Controller
{
    public function index(
        Request $request,
        Page $page
    ): View {
        $search =
            trim(
                (string) $request->query(
                    'q',
                    ''
                )
            );

        $categories =
            KnowledgebaseCategory::query()
                ->where(
                    'active',
                    true
                )
                ->withCount([
                    'articles' =>
                        fn ($query) =>
                            $query->where(
                                'active',
                                true
                            ),
                ])
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'name'
                )
                ->get();

        $searchArticles =
            KnowledgebaseArticle::query()
                ->where(
                    'active',
                    true
                )
                ->with(
                    'category'
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'title'
                )
                ->get()
                ->map(
                    function (
                        KnowledgebaseArticle $article
                    ) use (
                        $page
                    ): array {
                        return [
                            'title' =>
                                $article->title,

                            'description' =>
                                $article->short_description
                                ?? '',

                            'search_text' =>
                                Str::lower(
                                    trim(
                                        implode(
                                            ' ',
                                            [
                                                $article->title,
                                                $article->short_description
                                                    ?? '',
                                                strip_tags(
                                                    (string) $article->content
                                                ),
                                                $article->category?->name
                                                    ?? '',
                                            ]
                                        )
                                    )
                                ),

                            'category' =>
                                $article->category?->name
                                ?? '',

                            'url' =>
                                route(
                                    'knowledgebase.show',
                                    [
                                        'knowledgebase' =>
                                            $page->slug,

                                        'article' =>
                                            $article->slug,
                                    ]
                                ),
                        ];
                    }
                )
                ->values();

        return view(
            'knowledgebase.index',
            array_merge(
                SiteData::get(),
                [
                    'knowledgebase' =>
                        $this->knowledgebaseData(
                            $page
                        ),

                    'categories' =>
                        $categories,

                    'searchArticles' =>
                        $searchArticles,

                    'search' =>
                        $search,
                ]
            )
        );
    }

    public function category(
        string $knowledgebase,
        string $category
    ): View {
        $page =
            $this->resolvePage(
                $knowledgebase
            );

        $categoryModel =
            KnowledgebaseCategory::query()
                ->where(
                    'slug',
                    $category
                )
                ->where(
                    'active',
                    true
                )
                ->firstOrFail();

        $articles =
            KnowledgebaseArticle::query()
                ->where(
                    'knowledgebase_category_id',
                    $categoryModel->id
                )
                ->where(
                    'active',
                    true
                )
                ->with(
                    'category'
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'title'
                )
                ->paginate(
                    15
                );

        return view(
            'knowledgebase.category',
            array_merge(
                SiteData::get(),
                [
                    'knowledgebase' =>
                        $this->knowledgebaseData(
                            $page
                        ),

                    'category' =>
                        $categoryModel,

                    'articles' =>
                        $articles,
                ]
            )
        );
    }

    public function show(
        string $knowledgebase,
        string $article
    ): View {
        $page =
            $this->resolvePage(
                $knowledgebase
            );

        $articleModel =
            KnowledgebaseArticle::query()
                ->where(
                    'slug',
                    $article
                )
                ->where(
                    'active',
                    true
                )
                ->with(
                    'category'
                )
                ->firstOrFail();

        $related =
            KnowledgebaseArticle::query()
                ->where(
                    'active',
                    true
                )
                ->where(
                    'id',
                    '!=',
                    $articleModel->id
                )
                ->when(
                    $articleModel
                        ->knowledgebase_category_id,
                    fn ($query) =>
                        $query->where(
                            'knowledgebase_category_id',
                            $articleModel
                                ->knowledgebase_category_id
                        )
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'title'
                )
                ->limit(
                    6
                )
                ->get();

        return view(
            'knowledgebase.show',
            array_merge(
                SiteData::get(),
                [
                    'knowledgebase' =>
                        $this->knowledgebaseData(
                            $page
                        ),

                    'article' =>
                        $articleModel,

                    'related' =>
                        $related,
                ]
            )
        );
    }

    private function resolvePage(
        string $slug
    ): Page {
        return Page::query()
            ->where(
                'slug',
                $slug
            )
            ->where(
                'template',
                'knowledgebase'
            )
            ->where(
                'active',
                true
            )
            ->firstOrFail();
    }

    private function knowledgebaseData(
        Page $page
    ): array {
        $settings =
            Setting::query()
                ->where(
                    'group',
                    'knowledgebase'
                )
                ->pluck(
                    'value',
                    'key'
                );

        $heroImage =
            $settings->get(
                'knowledgebase_hero_background_image'
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
                    'knowledgebase_page_title'
                )
                ?: $page->title
                ?: 'Knowledgebase',

            'slug' =>
                $settings->get(
                    'knowledgebase_slug'
                )
                ?: $page->slug
                ?: 'knowledgebase',

            'description' =>
                $settings->get(
                    'knowledgebase_description'
                )
                ?: $page->short_description
                ?: '',

            'hero_enabled' =>
                $this->boolean(
                    $settings->get(
                        'knowledgebase_hero_enabled',
                        true
                    )
                ),

            'hero_alignment' =>
                $settings->get(
                    'knowledgebase_hero_alignment',
                    'center'
                )
                ?: 'center',

            'hero_eyebrow' =>
                $settings->get(
                    'knowledgebase_hero_eyebrow'
                )
                ?: 'Support',

            'hero_heading' =>
                $settings->get(
                    'knowledgebase_hero_heading'
                )
                ?: 'How can we help?',

            'hero_description' =>
                $settings->get(
                    'knowledgebase_hero_description'
                )
                ?: '',

            'hero_background_image' =>
                $heroImage,

            'seo_title' =>
                $settings->get(
                    'knowledgebase_seo_title'
                )
                ?: '',

            'seo_description' =>
                $settings->get(
                    'knowledgebase_seo_description'
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

