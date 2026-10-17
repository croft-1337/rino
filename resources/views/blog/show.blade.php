@extends('layouts.app')

@section(
    'title',
    (
        filled(
            $post->seo_title
        )
            ? $post->seo_title
            : $post->title
    )
    . ' | '
    . $siteName
)

@push('head')
    @if (
        filled(
            $post->seo_description
        )
    )
        <meta
            name="description"
            content="{{ $post->seo_description }}"
        >
    @elseif (
        filled(
            $post->excerpt
        )
    )
        <meta
            name="description"
            content="{{ $post->excerpt }}"
        >
    @endif
@endpush

@section('content')

    @php
        $articleUrl =
            url()->current();

        $articleTitle =
            $post->title;

        $author =
            filled(
                $post->author
            )
                ? $post->author
                : $siteName;

        $publishedDate =
            $post->published_date
                ? $post->published_date
                    ->format('d/m/Y')
                : '—';

        $readTime =
            $post->read_time
                ? $post->read_time . 'm'
                : '—';

        $shareUrl =
            urlencode(
                $articleUrl
            );

        $shareTitle =
            urlencode(
                $articleTitle
            );

        $morePostQuery =
            \App\Models\BlogPost::query()
                ->published()
                ->where(
                    'id',
                    '!=',
                    $post->getKey()
                );

        $morePost =
            null;

        if (
            $post->published_date
        ) {
            $postDate =
                $post->published_date
                    ->toDateString();

            $morePost =
                (clone $morePostQuery)
                    ->where(
                        function ($query) use (
                            $post,
                            $postDate
                        ): void {
                            $query
                                ->whereDate(
                                    'published_date',
                                    '>',
                                    $postDate
                                )
                                ->orWhere(
                                    function ($query) use (
                                        $post,
                                        $postDate
                                    ): void {
                                        $query
                                            ->whereDate(
                                                'published_date',
                                                $postDate
                                            )
                                            ->where(
                                                'id',
                                                '>',
                                                $post->getKey()
                                            );
                                    }
                                );
                        }
                    )
                    ->orderBy(
                        'published_date'
                    )
                    ->orderBy(
                        'id'
                    )
                    ->first();
        }

        if (!$morePost) {
            $morePost =
                $morePostQuery
                    ->orderByDesc(
                        'published_date'
                    )
                    ->orderByDesc(
                        'id'
                    )
                    ->first();
        }
    @endphp

    <article
        class="
            bg-rino-background
            px-4
            pb-16
            pt-12
            sm:px-6
            sm:pt-14
            lg:px-8
            lg:pb-20
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
                    grid
                    min-w-0
                    gap-10
                    lg:grid-cols-[minmax(0,13fr)_minmax(0,7fr)]
                    lg:items-start
                    xl:gap-12
                "
            >

                <main
                    class="
                        min-w-0
                    "
                >

                    <a
                        href="/{{ $blog['slug'] }}"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            text-sm
                            font-medium
                            text-rino-muted
                            transition-colors
                            hover:text-rino-heading
                        "
                    >
                        <svg
                            class="
                                size-4
                                shrink-0
                            "
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path
                                d="m15 18-6-6 6-6"
                            />
                        </svg>

                        <span>
                            Back to {{ $blog['title'] }}
                        </span>
                    </a>

                    <header
                        class="
                            mt-8
                        "
                    >
                        <h1
                            class="
                                max-w-5xl
                                text-[2.25rem]
                                font-bold
                                leading-[1.08]
                                tracking-tight
                                text-rino-heading
                                sm:text-[2.5rem]
                                lg:text-[2.875rem]
                            "
                        >
                            {{ $post->title }}
                        </h1>

                        @if (
                            filled(
                                $post->excerpt
                            )
                        )
                            <p
                                class="
                                    mt-5
                                    max-w-4xl
                                    text-base
                                    leading-[1.75]
                                    text-rino-muted
                                    sm:text-lg
                                "
                            >
                                {{ $post->excerpt }}
                            </p>
                        @endif
                    </header>

                    @if (
                        filled(
                            $post
                                ->featured_image
                        )
                    )

                        <div
                            class="
                                mt-9
                                overflow-hidden
                                rounded-[var(--radius-card)]
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
                            rino-blog-content
                            mt-10
                        "
                    >
                        {!! $post->content !!}
                    </div>

                </main>

                <aside
                    class="
                        lg:sticky
                        lg:top-[calc(var(--rino-top-stack-height)+1.5rem)]
                    "
                >
                    <div
                        class="
                            overflow-hidden
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            p-5
                            ring-1
                            ring-inset
                            ring-black/5
                        "
                    >

                        <dl
                            class="
                                space-y-4
                            "
                        >
                            <div
                                class="
                                    flex
                                    items-center
                                    justify-between
                                    gap-4
                                "
                            >
                                <dt
                                    class="
                                        text-sm
                                        text-rino-muted
                                    "
                                >
                                    Author
                                </dt>

                                <dd
                                    class="
                                        text-right
                                        text-sm
                                        font-bold
                                        text-rino-heading
                                    "
                                >
                                    {{ $author }}
                                </dd>
                            </div>

                            <div
                                class="
                                    flex
                                    items-center
                                    justify-between
                                    gap-4
                                "
                            >
                                <dt
                                    class="
                                        text-sm
                                        text-rino-muted
                                    "
                                >
                                    Read time
                                </dt>

                                <dd
                                    class="
                                        text-right
                                        text-sm
                                        font-bold
                                        text-rino-heading
                                    "
                                >
                                    {{ $readTime }}
                                </dd>
                            </div>

                            <div
                                class="
                                    flex
                                    items-center
                                    justify-between
                                    gap-4
                                "
                            >
                                <dt
                                    class="
                                        text-sm
                                        text-rino-muted
                                    "
                                >
                                    Date published
                                </dt>

                                <dd
                                    class="
                                        text-right
                                        text-sm
                                        font-bold
                                        text-rino-heading
                                    "
                                >
                                    {{ $publishedDate }}
                                </dd>
                            </div>
                        </dl>

                        <div
                            class="
                                my-5
                                h-px
                                bg-rino-border
                            "
                        ></div>

                        <div
                            class="
                                flex
                                flex-wrap
                                gap-2
                            "
                        >

                            <button
                                type="button"
                                data-copy-blog-link
                                data-url="{{ $articleUrl }}"
                                aria-label="Copy article link"
                                class="
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-rino-surface-secondary
                                    text-rino-heading
                                    transition
                                    hover:text-rino-primary
                                "
                            >
                                <svg
                                    class="size-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M10 13a5 5 0 0 0 7.07.07l2-2a5 5 0 0 0-7.07-7.07l-1.15 1.15"
                                    />
                                    <path
                                        d="M14 11a5 5 0 0 0-7.07-.07l-2 2A5 5 0 0 0 12 20l1.15-1.15"
                                    />
                                </svg>
                            </button>

                            <a
                                href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on LinkedIn"
                                class="
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-rino-surface-secondary
                                    text-rino-heading
                                    transition
                                    hover:text-rino-primary
                                "
                            >
                                <svg
                                    class="size-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M6.5 8.5H3.5V21H6.5V8.5ZM5 3A1.75 1.75 0 1 0 5 6.5 1.75 1.75 0 0 0 5 3ZM20.5 13.7C20.5 9.9 18.5 8.1 15.8 8.1C13.6 8.1 12.6 9.3 12 10.2V8.5H9V21H12V14.8C12 13.2 12.3 11.7 14.3 11.7C16.3 11.7 16.3 13.5 16.3 14.9V21H19.3V14.2C19.3 13.9 19.3 13.8 19.3 13.7H20.5Z"
                                    />
                                </svg>
                            </a>

                            <a
                                href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on X"
                                class="
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-rino-surface-secondary
                                    text-rino-heading
                                    transition
                                    hover:text-rino-primary
                                "
                            >
                                <svg
                                    class="size-[17px]"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M18.244 2H21.552L14.325 10.26L22.827 22H16.171L10.956 15.183L4.99 22H1.68L9.513 13.046L1.354 2H8.18L12.893 8.231L18.244 2ZM17.083 19.932H18.916L7.185 3.96H5.218L17.083 19.932Z"
                                    />
                                </svg>
                            </a>

                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Share on Facebook"
                                class="
                                    flex
                                    size-10
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-rino-surface-secondary
                                    text-rino-heading
                                    transition
                                    hover:text-rino-primary
                                "
                            >
                                <svg
                                    class="size-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M13.5 22V13.5H16.4L16.8 10.2H13.5V8.1C13.5 7.1 13.8 6.5 15.2 6.5H17V3.6C16.7 3.6 15.6 3.5 14.4 3.5C11.8 3.5 10 5.1 10 8V10.2H7V13.5H10V22H13.5Z"
                                    />
                                </svg>
                            </a>

                        </div>


                    </div>

                    @if ($morePost)

                        <div
                            class="
                                mt-8
                            "
                        >
                            <h2
                                class="
                                    mb-4
                                    text-xl
                                    font-bold
                                    tracking-tight
                                    text-rino-heading
                                "
                            >
                                More blogs
                            </h2>

                            <a
                                href="{{ $morePost->url }}"
                                class="
                                    block
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
                                        $morePost
                                            ->featured_image
                                    )
                                )

                                    <div
                                        class="
                                            overflow-hidden
                                        "
                                    >
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($morePost->featured_image) }}"
                                            alt="{{ $morePost->title }}"
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
                                        p-4
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
                                            $morePost
                                                ->published_date
                                        )
                                            <span>
                                                {{ $morePost->published_date->format('M j, Y') }}
                                            </span>
                                        @endif

                                        @if (
                                            $morePost
                                                ->published_date
                                            &&
                                            $morePost
                                                ->read_time
                                        )
                                            <span
                                                aria-hidden="true"
                                            >
                                                ·
                                            </span>
                                        @endif

                                        @if (
                                            $morePost
                                                ->read_time
                                        )
                                            <span>
                                                {{ $morePost->read_time }} min read
                                            </span>
                                        @endif
                                    </div>

                                    <h3
                                        class="
                                            mt-2
                                            line-clamp-2
                                            text-base
                                            font-bold
                                            leading-snug
                                            text-rino-heading
                                            transition-colors
                                        "
                                    >
                                        {{ $morePost->title }}
                                    </h3>

                                    @if (
                                        filled(
                                            $morePost->excerpt
                                        )
                                    )
                                        <p
                                            class="
                                                mt-2
                                                line-clamp-3
                                                text-sm
                                                leading-relaxed
                                                text-rino-muted
                                            "
                                        >
                                            {{ $morePost->excerpt }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        </div>

                    @endif

                </aside>

            </div>
        </div>
    </article>

    <style>
        .rino-blog-content {
            color: var(--text-body);
            font-size: 1rem;
            line-height: 1.8;
        }

        .rino-blog-content > :first-child {
            margin-top: 0;
        }

        .rino-blog-content > :last-child {
            margin-bottom: 0;
        }

        .rino-blog-content h1,
        .rino-blog-content h2,
        .rino-blog-content h3,
        .rino-blog-content h4,
        .rino-blog-content h5,
        .rino-blog-content h6 {
            color: var(--text-heading);
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }

        .rino-blog-content h1 {
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            font-size: 2.25rem;
        }

        .rino-blog-content h2 {
            margin-top: 2.25rem;
            margin-bottom: 0.9rem;
            font-size: 1.75rem;
        }

        .rino-blog-content h3 {
            margin-top: 1.9rem;
            margin-bottom: 0.75rem;
            font-size: 1.35rem;
        }

        .rino-blog-content h4 {
            margin-top: 1.6rem;
            margin-bottom: 0.65rem;
            font-size: 1.125rem;
        }

        .rino-blog-content p {
            margin-top: 0;
            margin-bottom: 1.15rem;
            color: var(--text-body);
        }

        .rino-blog-content strong,
        .rino-blog-content b {
            color: var(--text-heading);
            font-weight: 700;
        }

        .rino-blog-content em,
        .rino-blog-content i {
            font-style: italic;
        }

        .rino-blog-content u {
            text-decoration: underline;
            text-underline-offset: 0.15em;
        }

        .rino-blog-content s,
        .rino-blog-content del {
            text-decoration: line-through;
        }

        .rino-blog-content a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 0.2em;
        }

        .rino-blog-content ul,
        .rino-blog-content ol {
            margin-top: 0.75rem;
            margin-bottom: 1.25rem;
            padding-left: 1.5rem;
        }

        .rino-blog-content ul {
            list-style-type: disc;
        }

        .rino-blog-content ol {
            list-style-type: decimal;
        }

        .rino-blog-content li {
            margin: 0.35rem 0;
            padding-left: 0.15rem;
            color: var(--text-body);
        }

        .rino-blog-content li::marker {
            color: var(--primary);
        }

        .rino-blog-content blockquote {
            margin: 1.5rem 0;
            border-left: 3px solid var(--primary);
            border-radius: 0 var(--radius-card) var(--radius-card) 0;
            background:
                color-mix(
                    in srgb,
                    var(--surface) 88%,
                    transparent
                );
            padding: 1rem 1.25rem;
            color: var(--text-body);
        }

        .rino-blog-content blockquote p:last-child {
            margin-bottom: 0;
        }

        .rino-blog-content hr {
            margin: 2rem 0;
            border: 0;
            border-top: 1px solid var(--border);
        }

        .rino-blog-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 1.75rem 0;
            border-radius: var(--radius-card);
        }

        .rino-blog-content figure {
            margin: 1.75rem 0;
        }

        .rino-blog-content figcaption {
            margin-top: 0.65rem;
            color: var(--text-muted);
            font-size: 0.875rem;
            line-height: 1.5;
            text-align: center;
        }

        .rino-blog-content code {
            border-radius: 0.35rem;
            background:
                color-mix(
                    in srgb,
                    var(--surface-secondary) 90%,
                    transparent
                );
            padding: 0.15rem 0.35rem;
            color: var(--text-heading);
            font-size: 0.9em;
        }

        .rino-blog-content pre {
            margin: 1.5rem 0;
            overflow-x: auto;
            border-radius: var(--radius-card);
            background: var(--surface);
            padding: 1.25rem;
            box-shadow:
                inset 0 0 0 1px
                color-mix(
                    in srgb,
                    var(--border) 70%,
                    transparent
                );
        }

        .rino-blog-content pre code {
            background: transparent;
            padding: 0;
            color: var(--text-body);
        }

        .rino-blog-content table {
            width: 100%;
            margin: 1.5rem 0;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: var(--radius-card);
            font-size: 0.9375rem;
        }

        .rino-blog-content th,
        .rino-blog-content td {
            border: 1px solid var(--border);
            padding: 0.75rem 0.9rem;
            text-align: left;
            vertical-align: top;
        }

        .rino-blog-content th {
            background: var(--surface);
            color: var(--text-heading);
            font-weight: 700;
        }

        .rino-blog-content td {
            color: var(--text-body);
        }

        @media (max-width: 640px) {
            .rino-blog-content h1 {
                font-size: 1.875rem;
            }

            .rino-blog-content h2 {
                font-size: 1.5rem;
            }

            .rino-blog-content h3 {
                font-size: 1.25rem;
            }
        }
    </style>

    <script>
        (() => {
            const button =
                document.querySelector(
                    '[data-copy-blog-link]'
                );

            if (!button) {
                return;
            }

            button.addEventListener(
                'click',
                async () => {
                    const url =
                        button.dataset.url;

                    if (!url) {
                        return;
                    }

                    try {
                        await navigator
                            .clipboard
                            .writeText(
                                url
                            );

                        button.setAttribute(
                            'aria-label',
                            'Link copied'
                        );
                    } catch (error) {
                        console.error(
                            error
                        );
                    }
                }
            );
        })();
    </script>

@endsection
