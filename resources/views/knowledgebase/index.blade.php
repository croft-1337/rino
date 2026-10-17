@extends('layouts.app')

@section(
    'title',
    (
        filled(
            $knowledgebase[
                'seo_title'
            ]
            ?? null
        )
            ? $knowledgebase[
                'seo_title'
            ]
            : $knowledgebase[
                'title'
            ]
    )
    . ' | '
    . $siteName
)

@push('head')
    @if (
        filled(
            $knowledgebase[
                'seo_description'
            ]
            ?? null
        )
    )
        <meta
            name="description"
            content="{{ $knowledgebase['seo_description'] }}"
        >
    @endif
@endpush

@section('content')
    @if (
        $knowledgebase[
            'hero_enabled'
        ]
        ?? true
    )
        <section
            class="
                relative
                isolate
                overflow-visible
                bg-rino-background
            "
            style="
                margin-top:
                    calc(
                        -1 * var(--rino-header-height)
                    );

                padding-top:
                    var(--rino-header-height);
            "
        >
            @if (
                !empty(
                    $knowledgebase[
                        'hero_background_image'
                    ]
                )
            )
                <div
                    class="
                        absolute
                        inset-0
                        -z-30
                        overflow-hidden
                    "
                >
                    <img
                        src="{{ asset(ltrim($knowledgebase['hero_background_image'], '/')) }}"
                        alt=""
                        draggable="false"
                        class="
                            pointer-events-none
                            h-full
                            w-full
                            select-none
                            object-cover
                        "
                    >
                </div>

                <div
                    class="
                        absolute
                        inset-0
                        -z-20
                    "
                    style="
                        background:
                            color-mix(
                                in srgb,
                                var(--background) 68%,
                                transparent
                            );
                    "
                ></div>

                <div
                    class="
                        absolute
                        inset-x-0
                        bottom-0
                        -z-10
                        h-24
                    "
                    style="
                        background:
                            linear-gradient(
                                to bottom,
                                transparent,
                                var(--background)
                            );
                    "
                ></div>
            @endif

            <div
                class="
                    mx-auto
                    max-w-5xl
                    px-4
                    pb-14
                    pt-12
                    sm:px-6
                    sm:pb-16
                    sm:pt-14
                    lg:px-8
                "
            >
                <div
                    class="
                        {{ ($knowledgebase['hero_alignment'] ?? 'center') === 'left'
                            ? 'text-left'
                            : 'text-center'
                        }}
                    "
                >
                    @if (
                        filled(
                            $knowledgebase[
                                'hero_eyebrow'
                            ]
                            ?? null
                        )
                    )
                        <div
                            class="
                                inline-flex
                                items-center
                                rounded-full
                                bg-rino-primary
                                px-4
                                py-2
                                text-sm
                                font-semibold
                                text-rino-primary-text
                            "
                        >
                            {{ $knowledgebase['hero_eyebrow'] }}
                        </div>
                    @endif

                    <h1
                        class="
                            mt-5
                            text-[2rem]
                            font-bold
                            leading-tight
                            tracking-tight
                            text-rino-heading
                            sm:text-[2.25rem]
                            lg:text-[2.5rem]
                        "
                    >
                        {{ $knowledgebase['hero_heading'] }}
                    </h1>

                    @if (
                        filled(
                            $knowledgebase[
                                'hero_description'
                            ]
                            ?? null
                        )
                    )
                        <p
                            class="
                                mx-auto
                                mt-4
                                max-w-2xl
                                text-[0.9375rem]
                                leading-[1.7]
                                text-rino-muted
                                sm:text-base
                            "
                        >
                            {{ $knowledgebase['hero_description'] }}
                        </p>
                    @endif

                    <div
                        class="
                            relative
                            mx-auto
                            mt-7
                            max-w-3xl
                            text-left
                        "
                        data-kb-search
                    >
                        <div
                            class="
                                relative
                                overflow-hidden
                                rounded-[var(--radius-button)]
                                bg-rino-surface
                                shadow-xl
                            "
                        >
                            <input
                                type="search"
                                value="{{ $search }}"
                                autocomplete="off"
                                placeholder="Search the knowledgebase"
                                aria-label="Search the knowledgebase"
                                data-kb-search-input
                                class="
                                    h-14
                                    w-full
                                    border-0
                                    bg-transparent
                                    px-5
                                    pr-14
                                    text-base
                                    text-rino-heading
                                    outline-none
                                    ring-0
                                    placeholder:text-rino-muted
                                    focus:border-0
                                    focus:outline-none
                                    focus:ring-0
                                "
                            >

                            <span
                                class="
                                    pointer-events-none
                                    absolute
                                    right-5
                                    top-1/2
                                    flex
                                    size-5
                                    -translate-y-1/2
                                    items-center
                                    justify-center
                                    text-rino-muted
                                "
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-5"
                                    aria-hidden="true"
                                >
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <path d="m20 20-3.5-3.5"></path>
                                </svg>
                            </span>
                        </div>

                        <div
                            data-kb-search-results
                            class="
                                absolute
                                inset-x-0
                                top-full
                                z-50
                                mt-2
                                hidden
                                max-h-[28rem]
                                overflow-y-auto
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                p-2
                                shadow-2xl
                                ring-1
                                ring-inset
                                ring-black/5
                            "
                        ></div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section
        class="
            bg-rino-background
            px-4
            pb-16
            pt-12
            sm:px-6
            lg:px-8
        "
    >
        <div
            class="
                mx-auto
                max-w-7xl
            "
        >
            <h2
                class="
                    text-2xl
                    font-bold
                    tracking-tight
                    text-rino-heading
                    sm:text-[1.75rem]
                "
            >
                Browse Categories
            </h2>

            @if (
                $categories->isNotEmpty()
            )
                <div
                    class="
                        mt-7
                        grid
                        gap-4
                        sm:grid-cols-2
                        lg:grid-cols-3
                    "
                >
                    @foreach (
                        $categories
                        as $category
                    )
                        <a
                            href="{{ route(
                                'knowledgebase.category',
                                [
                                    'knowledgebase' =>
                                        $knowledgebase[
                                            'slug'
                                        ],

                                    'category' =>
                                        $category->slug,
                                ]
                            ) }}"
                            class="
                                flex
                                min-h-32
                                items-start
                                gap-4
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                p-5
                                ring-1
                                ring-inset
                                ring-black/5
                            "
                        >
                            <span
                                class="
                                    mt-0.5
                                    flex
                                    size-6
                                    shrink-0
                                    items-center
                                    justify-center
                                    text-rino-primary
                                "
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-6"
                                    aria-hidden="true"
                                >
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"></path>
                                </svg>
                            </span>

                            <div class="min-w-0">
                                <h3
                                    class="
                                        text-base
                                        font-bold
                                        text-rino-heading
                                    "
                                >
                                    {{ $category->name }}
                                </h3>

                                @if (
                                    filled(
                                        $category->description
                                    )
                                )
                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            leading-[1.65]
                                            text-rino-muted
                                        "
                                    >
                                        {{ $category->description }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div
                    class="
                        mt-7
                        rounded-[var(--radius-card)]
                        bg-rino-surface
                        p-8
                        text-center
                    "
                >
                    <p class="text-rino-muted">
                        No knowledgebase categories are available yet.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <script>
        (() => {
            const root =
                document.querySelector(
                    '[data-kb-search]'
                );

            if (!root) {
                return;
            }

            const input =
                root.querySelector(
                    '[data-kb-search-input]'
                );

            const results =
                root.querySelector(
                    '[data-kb-search-results]'
                );

            if (
                !input
                ||
                !results
            ) {
                return;
            }

            const articles =
                @js($searchArticles);

            const escapeHtml =
                value =>
                    String(value ?? '')
                        .replaceAll(
                            '&',
                            '&amp;'
                        )
                        .replaceAll(
                            '<',
                            '&lt;'
                        )
                        .replaceAll(
                            '>',
                            '&gt;'
                        )
                        .replaceAll(
                            '"',
                            '&quot;'
                        )
                        .replaceAll(
                            "'",
                            '&#039;'
                        );

            const close =
                () => {
                    results.innerHTML =
                        '';

                    results.classList.add(
                        'hidden'
                    );
                };

            const render =
                () => {
                    const query =
                        input.value
                            .trim()
                            .toLowerCase();

                    if (!query) {
                        close();

                        return;
                    }

                    const terms =
                        query
                            .split(/\s+/)
                            .filter(Boolean);

                    const matches =
                        articles
                            .filter(
                                article =>
                                    terms.every(
                                        term =>
                                            article.search_text
                                                .includes(
                                                    term
                                                )
                                    )
                            )
                            .slice(
                                0,
                                10
                            );

                    if (!matches.length) {
                        results.innerHTML =
                            `
                                <div class="
                                    px-4
                                    py-4
                                    text-sm
                                    text-rino-muted
                                ">
                                    No articles found.
                                </div>
                            `;

                        results.classList.remove(
                            'hidden'
                        );

                        return;
                    }

                    results.innerHTML =
                        matches
                            .map(
                                article => `
                                    <a
                                        href="${escapeHtml(article.url)}"
                                        class="
                                            flex
                                            items-start
                                            gap-3
                                            rounded-[var(--radius-button)]
                                            px-3
                                            py-3
                                            no-underline
                                            hover:bg-rino-surface-secondary
                                        "
                                    >
                                        <span
                                            class="
                                                mt-0.5
                                                flex
                                                size-5
                                                shrink-0
                                                items-center
                                                justify-center
                                                text-rino-primary
                                            "
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="size-5"
                                                aria-hidden="true"
                                            >
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"></path>
                                            </svg>
                                        </span>

                                        <span class="min-w-0 flex-1">
                                            <span
                                                class="
                                                    block
                                                    truncate
                                                    text-sm
                                                    font-semibold
                                                    text-rino-heading
                                                "
                                            >
                                                ${escapeHtml(article.title)}
                                            </span>

                                            ${
                                                article.description
                                                    ? `
                                                        <span
                                                            class="
                                                                mt-1
                                                                block
                                                                line-clamp-2
                                                                text-xs
                                                                leading-relaxed
                                                                text-rino-muted
                                                            "
                                                        >
                                                            ${escapeHtml(article.description)}
                                                        </span>
                                                    `
                                                    : ''
                                            }

                                            ${
                                                article.category
                                                    ? `
                                                        <span
                                                            class="
                                                                mt-1.5
                                                                block
                                                                text-xs
                                                                font-medium
                                                                text-rino-primary
                                                            "
                                                        >
                                                            ${escapeHtml(article.category)}
                                                        </span>
                                                    `
                                                    : ''
                                            }
                                        </span>
                                    </a>
                                `
                            )
                            .join('');

                    results.classList.remove(
                        'hidden'
                    );
                };

            input.addEventListener(
                'input',
                render
            );

            input.addEventListener(
                'focus',
                render
            );

            document.addEventListener(
                'click',
                event => {
                    if (
                        !root.contains(
                            event.target
                        )
                    ) {
                        close();
                    }
                }
            );

            document.addEventListener(
                'keydown',
                event => {
                    if (
                        event.key
                        ===
                        'Escape'
                    ) {
                        close();

                        input.blur();
                    }
                }
            );
        })();
    </script>
@endsection