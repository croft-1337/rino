@extends('layouts.app')

@section(
    'title',
    (
        filled(
            $blog['seo_title']
            ?? null
        )
            ? $blog['seo_title']
            : $blog['title']
    )
    . ' | '
    . $siteName
)



@section('content')

    @if (
        $blog['hero_enabled']
        ?? true
    )

        <section
            class="
                relative
                isolate
                overflow-hidden
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
                    $blog[
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
                        src="{{ asset(ltrim($blog['hero_background_image'], '/')) }}"
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
                            linear-gradient(
                                to bottom,
                                color-mix(
                                    in srgb,
                                    var(--background) 58%,
                                    transparent
                                ) 0%,
                                color-mix(
                                    in srgb,
                                    var(--background) 76%,
                                    transparent
                                ) 58%,
                                var(--background) 100%
                            );
                    "
                ></div>

                <div
                    class="
                        absolute
                        inset-x-0
                        bottom-0
                        -z-10
                        h-12
                        sm:h-16
                        lg:h-20
                    "
                    style="
                        background:
                            linear-gradient(
                                to top,
                                var(--background),
                                transparent
                            );
                    "
                ></div>

            @else

                <div
                    class="
                        absolute
                        inset-0
                        -z-30
                        bg-rino-background
                    "
                ></div>

            @endif

            <div
                class="
                    relative
                    mx-auto
                    flex
                    w-full
                    max-w-7xl
                    items-center
                    px-4
                    py-7
                    sm:min-h-[350px]
                    sm:px-6
                    sm:py-8
                    lg:min-h-[380px]
                    lg:px-8
                    lg:py-10
                "
            >
                <div
                    class="
                        w-full
                        max-w-3xl
                        -translate-y-2
                        sm:-translate-y-3

                        {{ ($blog['hero_alignment'] ?? 'left') === 'center'
                            ? 'mx-auto text-center'
                            : 'text-left'
                        }}
                    "
                >

                    @if (
                        filled(
                            $blog[
                                'hero_eyebrow'
                            ]
                            ?? null
                        )
                    )

                        <div
                            class="
                                mb-4
                                flex

                                {{ ($blog['hero_alignment'] ?? 'left') === 'center'
                                    ? 'justify-center'
                                    : 'justify-start'
                                }}
                            "
                        >
                            <span
                                class="
                                    inline-flex
                                    items-center
                                    bg-rino-primary
                                    px-4
                                    py-2
                                    text-sm
                                    font-semibold
                                    text-rino-primary-text
                                "
                                style="
                                    border-radius:
                                        var(--radius-button);
                                "
                            >
                                {{ $blog['hero_eyebrow'] }}
                            </span>
                        </div>

                    @endif

                    <h1
                        class="
                            max-w-4xl
                            text-[2rem]
                            font-bold
                            leading-[1.08]
                            tracking-tight
                            text-rino-heading
                            sm:text-[2.25rem]
                            md:text-[2.5rem]
                            lg:text-[2.75rem]

                            {{ ($blog['hero_alignment'] ?? 'left') === 'center'
                                ? 'mx-auto'
                                : ''
                            }}
                        "
                    >
                        {{ filled(
                            $blog[
                                'hero_heading'
                            ]
                            ?? null
                        )
                            ? $blog['hero_heading']
                            : $blog['title']
                        }}
                    </h1>

                    @if (
                        filled(
                            $blog[
                                'hero_description'
                            ]
                            ?? null
                        )
                    )

                        <p
                            class="
                                mt-4
                                max-w-2xl
                                text-[15px]
                                leading-7
                                text-rino-muted
                                sm:text-base
                                lg:text-lg

                                {{ ($blog['hero_alignment'] ?? 'left') === 'center'
                                    ? 'mx-auto'
                                    : ''
                                }}
                            "
                        >
                            {{ $blog['hero_description'] }}
                        </p>

                    @endif

                </div>
            </div>

        </section>

    @else

        <section
            class="
                bg-rino-background
                px-4
                py-14
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
                <h1
                    class="
                        text-[2.5rem]
                        font-bold
                        tracking-tight
                        text-rino-heading
                    "
                >
                    {{ $blog['title'] }}
                </h1>

                @if (
                    filled(
                        $blog[
                            'description'
                        ]
                        ?? null
                    )
                )
                    <p
                        class="
                            mt-3
                            max-w-2xl
                            text-base
                            leading-[1.7]
                            text-rino-muted
                        "
                    >
                        {{ $blog['description'] }}
                    </p>
                @endif
            </div>
        </section>

    @endif

    <section
        class="
            bg-rino-background
            px-4
            py-14
            sm:px-6
            lg:px-8
            lg:py-16
        "
    >
        <div
            class="
                mx-auto
                max-w-7xl
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-6
                    lg:flex-row
                    lg:items-end
                    lg:justify-between
                "
            >
                <div>
                    <h2
                        class="
                            text-[2rem]
                            font-bold
                            tracking-tight
                            text-rino-heading
                            sm:text-[2.25rem]
                            lg:text-[2.5rem]
                        "
                    >
                        Latest Posts
                    </h2>

                    @if (
                        filled(
                            $blog[
                                'description'
                            ]
                            ?? null
                        )
                    )
                        <p
                            class="
                                mt-2
                                max-w-2xl
                                text-[0.9375rem]
                                leading-[1.7]
                                text-rino-muted
                                sm:text-[1rem]
                            "
                        >
                            {{ $blog['description'] }}
                        </p>
                    @endif
                </div>

                <div
                    class="
                        relative
                        w-full
                        max-w-sm
                    "
                >
                    <svg
                        class="
                            pointer-events-none
                            absolute
                            left-4
                            top-1/2
                            size-[18px]
                            -translate-y-1/2
                            text-rino-muted
                        "
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                        />
                        <path
                            d="m20 20-3.5-3.5"
                        />
                    </svg>

                    <input
                        id="blog-search"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Search posts"
                        autocomplete="off"
                        class="
                            min-h-11
                            w-full
                            rounded-[var(--radius-input)]
                            bg-rino-surface
                            py-2.5
                            pl-11
                            pr-4
                            text-sm
                            text-rino-heading
                            outline-none
                            ring-0
                            placeholder:text-rino-muted
                            focus:outline-none
                            focus:ring-0
                        "
                    >
                </div>
            </div>

            @if (
                $tags->isNotEmpty()
            )

                <div
                    class="
                        mt-8
                        flex
                        flex-wrap
                        gap-2
                    "
                >
                    <a
                        href="/{{ $blog['slug'] }}"
                        class="
                            rounded-full
                            px-4
                            py-2
                            text-sm
                            font-semibold
                            transition

                            {{ $selectedTag === 'all'
                                ? 'bg-rino-primary text-rino-primary-text'
                                : 'bg-rino-surface text-rino-body hover:text-rino-heading'
                            }}
                        "
                    >
                        All
                    </a>

                    @foreach (
                        $tags->filter(
                            fn ($tag) =>
                                strtolower(
                                    (string) $tag->slug
                                ) !== 'all'
                                &&
                                strtolower(
                                    (string) $tag->name
                                ) !== 'all'
                        )
                        as $tag
                    )

                        <a
                            href="/{{ $blog['slug'] }}?tag={{ $tag->slug }}"
                            class="
                                rounded-full
                                px-4
                                py-2
                                text-sm
                                font-semibold
                                transition

                                {{ $selectedTag === $tag->slug
                                    ? 'bg-rino-primary text-rino-primary-text'
                                    : 'bg-rino-surface text-rino-body hover:text-rino-heading'
                                }}
                            "
                        >
                            {{ $tag->name }}
                        </a>

                    @endforeach
                </div>

            @endif

            <div
                id="blog-post-results"
            >

                @if (
                    $posts->isNotEmpty()
                )

                    <div
                        class="
                            mt-10
                            grid
                            grid-cols-1
                            gap-5
                            md:grid-cols-2
                            lg:grid-cols-3
                        "
                    >

                        @foreach (
                            $posts
                            as $post
                        )

                            <a
                                href="{{ $post->url }}"
                                class="
                                    flex
                                    min-w-0
                                    flex-col
                                    overflow-hidden
                                    rounded-[var(--radius-card)]
                                    bg-rino-surface
                                    ring-1
                                    ring-inset
                                    ring-black/5
                                "
                            >

                                @if (
                                    filled(
                                        $post
                                            ->featured_image
                                    )
                                )

                                    <div
                                        class="
                                            overflow-hidden
                                        "
                                    >
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
                                            alt="{{ $post->title }}"
                                            class="
                                                aspect-[16/9]
                                                w-full
                                                object-cover
                                            "
                                        >
                                    </div>

                                @endif

                                <div
                                    class="
                                        flex
                                        flex-1
                                        flex-col
                                        p-5
                                    "
                                >
                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            items-center
                                            gap-x-2
                                            gap-y-1
                                            text-xs
                                            font-medium
                                            text-rino-muted
                                        "
                                    >
                                        @if (
                                            $post
                                                ->published_date
                                        )
                                            <span>
                                                {{ $post->published_date->format('M j, Y') }}
                                            </span>
                                        @endif

                                        @if (
                                            $post
                                                ->published_date
                                            &&
                                            $post
                                                ->read_time
                                        )
                                            <span
                                                aria-hidden="true"
                                            >
                                                ·
                                            </span>
                                        @endif

                                        @if (
                                            $post
                                                ->read_time
                                        )
                                            <span>
                                                {{ $post->read_time }} min read
                                            </span>
                                        @endif
                                    </div>

                                    <h3
                                        class="
                                            mt-3
                                            line-clamp-2
                                            text-xl
                                            font-bold
                                            leading-snug
                                            text-rino-heading
                                            transition-colors
                                        "
                                    >
                                        {{ $post->title }}
                                    </h3>

                                    @if (
                                        filled(
                                            $post->excerpt
                                        )
                                    )
                                        <p
                                            class="
                                                mt-3
                                                line-clamp-3
                                                text-sm
                                                leading-relaxed
                                                text-rino-muted
                                            "
                                        >
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                </div>
                            </a>

                        @endforeach

                    </div>

                    <div
                        id="blog-pagination"
                        class="mt-10"
                    >
                        {{ $posts->links() }}
                    </div>

                @else

                    <div
                        class="
                            mt-10
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            p-10
                            text-center
                            ring-1
                            ring-inset
                            ring-black/5
                        "
                    >
                        <h3
                            class="
                                text-xl
                                font-bold
                                text-rino-heading
                            "
                        >
                            No posts found
                        </h3>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-rino-muted
                            "
                        >
                            Try another search or category.
                        </p>
                    </div>

                @endif

            </div>

        </div>
    </section>

    <script>
        (() => {
            const input =
                document.getElementById(
                    'blog-search'
                );

            const results =
                document.getElementById(
                    'blog-post-results'
                );

            if (
                !input
                ||
                !results
            ) {
                return;
            }

            let timer =
                null;

            let controller =
                null;

            const selectedTag =
                @js($selectedTag);

            const blogPath =
                @js('/' . ltrim($blog['slug'], '/'));

            const search =
                async value => {
                    if (controller) {
                        controller.abort();
                    }

                    controller =
                        new AbortController();

                    const params =
                        new URLSearchParams();

                    const query =
                        String(
                            value
                            ?? ''
                        ).trim();

                    if (
                        selectedTag
                        &&
                        selectedTag !== 'all'
                    ) {
                        params.set(
                            'tag',
                            selectedTag
                        );
                    }

                    if (query) {
                        params.set(
                            'q',
                            query
                        );
                    }

                    const url =
                        blogPath
                        +
                        (
                            params.toString()
                                ? '?'
                                    + params.toString()
                                : ''
                        );

                    try {
                        const response =
                            await fetch(
                                url,
                                {
                                    headers: {
                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                    },
                                    signal:
                                        controller.signal,
                                }
                            );

                        if (
                            !response.ok
                        ) {
                            return;
                        }

                        const html =
                            await response.text();

                        const documentCopy =
                            new DOMParser()
                                .parseFromString(
                                    html,
                                    'text/html'
                                );

                        const fresh =
                            documentCopy
                                .getElementById(
                                    'blog-post-results'
                                );

                        if (!fresh) {
                            return;
                        }

                        results.innerHTML =
                            fresh.innerHTML;

                        window.history.replaceState(
                            {},
                            '',
                            url
                        );
                    } catch (error) {
                        if (
                            error.name
                            !==
                            'AbortError'
                        ) {
                            console.error(
                                error
                            );
                        }
                    }
                };

            input.addEventListener(
                'input',
                () => {
                    clearTimeout(
                        timer
                    );

                    timer =
                        setTimeout(
                            () => {
                                search(
                                    input.value
                                );
                            },
                            220
                        );
                }
            );
        })();
    </script>

@endsection
