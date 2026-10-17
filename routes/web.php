<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\KnowledgebaseController;
use App\Models\Page;
use App\Models\Setting;
use App\Support\SiteData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get(
    '/',
    function () {
        return view(
            'home',
            SiteData::get()
        );
    }
);

Route::post(
    '/currency',
    function (
        Request $request
    ): RedirectResponse {
        $request->validate([
            'currency' => [
                'required',
                'string',
                'size:3',
            ],
        ]);

        $enabledCurrencies =
            json_decode(
                Setting::query()
                    ->where(
                        'key',
                        'enabled_currencies'
                    )
                    ->value(
                        'value'
                    )
                    ?: '[]',
                true
            );

        if (
            !is_array(
                $enabledCurrencies
            )
        ) {
            $enabledCurrencies = [];
        }

        $currency =
            strtoupper(
                $request
                    ->string(
                        'currency'
                    )
                    ->toString()
            );

        if (
            !in_array(
                $currency,
                $enabledCurrencies,
                true
            )
        ) {
            abort(422);
        }

        session([
            'currency' =>
                $currency,
        ]);

        return redirect()->back();
    }
)->name(
    'currency.switch'
);

Route::post(
    '/cookie-consent',
    function (
        Request $request
    ): RedirectResponse {
        $request->validate([
            'choice' => [
                'required',
                'in:analytics,essential',
            ],
        ]);

        $analyticsEnabled =
            filter_var(
                Setting::query()
                    ->where(
                        'key',
                        'cookie_analytics_enabled'
                    )
                    ->value(
                        'value'
                    )
                    ?? true,
                FILTER_VALIDATE_BOOLEAN
            );

        $choice =
            $request
                ->string(
                    'choice'
                )
                ->toString();

        if (
            !$analyticsEnabled
        ) {
            $choice =
                'essential';
        }

        $response =
            redirect()->back();

        $response->withCookie(
            cookie(
                'rino_cookie_consent',
                $choice,
                60 * 24 * 365,
                '/',
                null,
                $request->isSecure(),
                false,
                false,
                'lax'
            )
        );

        if (
            $choice ===
            'essential'
        ) {
            $response->withCookie(
                cookie()->forget(
                    'rino_visitor',
                    '/'
                )
            );
        }

        return $response;
    }
)->name(
    'cookie-consent.update'
);

Route::get(
    '/{knowledgebase}/category/{category}',
    function (
        string $knowledgebase,
        string $category
    ) {
        $page =
            Page::query()
                ->where(
                    'slug',
                    $knowledgebase
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

        return app(
            KnowledgebaseController::class
        )->category(
            $page->slug,
            $category
        );
    }
)
    ->where(
        'knowledgebase',
        '[A-Za-z0-9\-]+'
    )
    ->where(
        'category',
        '[A-Za-z0-9\-]+'
    )
    ->name(
        'knowledgebase.category'
    );

Route::get(
    '/{knowledgebase}/{article}',
    function (
        string $knowledgebase,
        string $article
    ) {
        $page =
            Page::query()
                ->where(
                    'slug',
                    $knowledgebase
                )
                ->where(
                    'template',
                    'knowledgebase'
                )
                ->where(
                    'active',
                    true
                )
                ->first();

        if ($page) {
            return app(
                KnowledgebaseController::class
            )->show(
                $page->slug,
                $article
            );
        }

        $configuredBlogSlug =
            Str::slug(
                (string) (
                    Setting::query()
                        ->where(
                            'key',
                            'blog_slug'
                        )
                        ->value(
                            'value'
                        )
                    ?: 'blog'
                )
            );

        if (
            !$configuredBlogSlug
        ) {
            $configuredBlogSlug =
                'blog';
        }

        if (
            $knowledgebase ===
            $configuredBlogSlug
        ) {
            return app(
                BlogController::class
            )->show(
                $article
            );
        }

        abort(404);
    }
)
    ->where(
        'knowledgebase',
        '[A-Za-z0-9\-]+'
    )
    ->where(
        'article',
        '[A-Za-z0-9\-]+'
    )
    ->name(
        'knowledgebase.show'
    );

Route::get(
    '/{slug}',
    function (
        Request $request,
        string $slug
    ) {
        $configuredBlogSlug =
            Str::slug(
                (string) (
                    Setting::query()
                        ->where(
                            'key',
                            'blog_slug'
                        )
                        ->value(
                            'value'
                        )
                    ?: 'blog'
                )
            );

        if (
            !$configuredBlogSlug
        ) {
            $configuredBlogSlug =
                'blog';
        }

        if (
            $slug ===
            $configuredBlogSlug
        ) {
            return app(
                BlogController::class
            )->index(
                $request
            );
        }

        $page =
            Page::query()
                ->where(
                    'slug',
                    $slug
                )
                ->where(
                    'active',
                    true
                )
                ->whereIn(
                    'page_type',
                    [
                        Page::TYPE_STRUCTURED,
                        Page::TYPE_DOCUMENT,
                    ]
                )
                ->firstOrFail();

        if (
            $page->template ===
            'knowledgebase'
        ) {
            return app(
                KnowledgebaseController::class
            )->index(
                $request,
                $page
            );
        }

        return view(
            'pages.show',
            array_merge(
                SiteData::get(),
                [
                    'page' =>
                        $page,
                ]
            )
        );
    }
)
    ->where(
        'slug',
        '[A-Za-z0-9\-]+'
    )
    ->name(
        'dynamic.content.index'
    );