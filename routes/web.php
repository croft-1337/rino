<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\KnowledgebaseController;
use App\Models\BlogPost;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseCategory;
use App\Models\Page;
use App\Models\Setting;
use App\Support\SiteData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('home', SiteData::get());
});

Route::post('/currency', function (Request $request): RedirectResponse {
    $request->validate([
        'currency' => [
            'required',
            'string',
            'size:3',
        ],
    ]);

    $enabledCurrencies = json_decode(
        Setting::query()
            ->where('key', 'enabled_currencies')
            ->value('value') ?: '[]',
        true
    );

    if (!is_array($enabledCurrencies)) {
        $enabledCurrencies = [];
    }

    $currency = strtoupper(
        $request->string('currency')->toString()
    );

    if (!in_array($currency, $enabledCurrencies, true)) {
        abort(422);
    }

    session([
        'currency' => $currency,
    ]);

    return redirect()->back();
})->name('currency.switch');

Route::post('/cookie-consent', function (Request $request): RedirectResponse {
    $request->validate([
        'choice' => [
            'required',
            'in:analytics,essential',
        ],
    ]);

    $analyticsEnabled = filter_var(
        Setting::query()
            ->where('key', 'cookie_analytics_enabled')
            ->value('value') ?? true,
        FILTER_VALIDATE_BOOLEAN
    );

    $choice = $request->string('choice')->toString();

    if (!$analyticsEnabled) {
        $choice = 'essential';
    }

    $response = redirect()->back();

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

    if ($choice === 'essential') {
        $response->withCookie(
            cookie()->forget('rino_visitor', '/')
        );
    }

    return $response;
})->name('cookie-consent.update');

Route::get('/sitemap.xml', function () {
    $robots = Setting::query()
        ->where('key', 'seo_robots')
        ->value('value') ?: 'index,follow';

    $urls = [];

    if (!str_contains(strtolower($robots), 'noindex')) {
        $urls[] = url('/');

        $pages = Page::query()
            ->where('active', true)
            ->where('published', true)
            ->whereIn('page_type', [
                Page::TYPE_STRUCTURED,
                Page::TYPE_DOCUMENT,
            ])
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get();

        foreach ($pages as $page) {
            if ($page->slug !== 'home') {
                $urls[] = url('/'.ltrim($page->slug, '/'));
            }
        }

        $blogSlug = Str::slug(
            (string) (
                Setting::query()
                    ->where('key', 'blog_slug')
                    ->value('value') ?: 'blog'
            )
        ) ?: 'blog';

        $urls[] = url('/'.$blogSlug);

        foreach (BlogPost::query()->published()->get() as $post) {
            $urls[] = url($post->url);
        }

        $kbPages = $pages->where('template', 'knowledgebase');

        if ($kbPages->isNotEmpty()) {
            $categories = KnowledgebaseCategory::query()
                ->where('active', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->get();

            $articles = KnowledgebaseArticle::query()
                ->where('active', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->whereHas('category', function ($query) {
                    $query->where('active', true);
                })
                ->get();

            foreach ($kbPages as $kbPage) {
                foreach ($categories as $category) {
                    $urls[] = url(
                        '/'.$kbPage->slug.'/category/'.$category->slug
                    );
                }

                foreach ($articles as $article) {
                    $urls[] = url(
                        '/'.$kbPage->slug.'/'.$article->slug
                    );
                }
            }
        }
    }

    $xml = new SimpleXMLElement(
        '<?xml version="1.0" encoding="UTF-8"?>'
        .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>'
    );

    foreach (array_unique($urls) as $url) {
        $xml->addChild('url')
            ->addChild(
                'loc',
                htmlspecialchars($url, ENT_XML1, 'UTF-8')
            );
    }

    return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('seo.sitemap');

Route::get(
    '/{knowledgebase}/category/{category}',
    function (string $knowledgebase, string $category) {
        $page = Page::query()
            ->where('slug', $knowledgebase)
            ->where('template', 'knowledgebase')
            ->where('active', true)
            ->where('published', true)
            ->firstOrFail();

        return app(KnowledgebaseController::class)->category(
            $page->slug,
            $category
        );
    }
)
    ->where('knowledgebase', '[A-Za-z0-9\-]+')
    ->where('category', '[A-Za-z0-9\-]+')
    ->name('knowledgebase.category');

Route::get(
    '/{knowledgebase}/{article}',
    function (string $knowledgebase, string $article) {
        $page = Page::query()
            ->where('slug', $knowledgebase)
            ->where('template', 'knowledgebase')
            ->where('active', true)
            ->where('published', true)
            ->first();

        if ($page) {
            return app(KnowledgebaseController::class)->show(
                $page->slug,
                $article
            );
        }

        $configuredBlogSlug = Str::slug(
            (string) (
                Setting::query()
                    ->where('key', 'blog_slug')
                    ->value('value') ?: 'blog'
            )
        ) ?: 'blog';

        if ($knowledgebase === $configuredBlogSlug) {
            return app(BlogController::class)->show($article);
        }

        abort(404);
    }
)
    ->where('knowledgebase', '[A-Za-z0-9\-]+')
    ->where('article', '[A-Za-z0-9\-]+')
    ->name('knowledgebase.show');

Route::get(
    '/{slug}',
    function (Request $request, string $slug) {
        $configuredBlogSlug = Str::slug(
            (string) (
                Setting::query()
                    ->where('key', 'blog_slug')
                    ->value('value') ?: 'blog'
            )
        ) ?: 'blog';

        if ($slug === $configuredBlogSlug) {
            return app(BlogController::class)->index($request);
        }

        $page = Page::query()
            ->where('slug', $slug)
            ->where('active', true)
            ->where('published', true)
            ->whereIn('page_type', [
                Page::TYPE_STRUCTURED,
                Page::TYPE_DOCUMENT,
            ])
            ->firstOrFail();

        if ($page->template === 'knowledgebase') {
            return app(KnowledgebaseController::class)->index(
                $request,
                $page
            );
        }

        return view(
            'pages.show',
            array_merge(
                SiteData::get(),
                [
                    'page' => $page,
                ]
            )
        );
    }
)
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('dynamic.content.index');
