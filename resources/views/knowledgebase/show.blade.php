@extends('layouts.app')

@section(
    'title',
    $article->title
    . ' | '
    . $knowledgebase['title']
    . ' | '
    . $siteName
)



@section('content')
    <article
        class="
            bg-rino-background
            px-4
            pb-16
            pt-10
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
            <nav
                class="
                    flex
                    flex-wrap
                    items-center
                    gap-2
                    text-sm
                    text-rino-muted
                "
                aria-label="Breadcrumb"
            >
                <a
                    href="/{{ $knowledgebase['slug'] }}"
                    class="
                        font-semibold
                        text-rino-primary
                        no-underline
                    "
                >
                    {{ $knowledgebase['title'] }}
                </a>

                @if (
                    $article->category
                )
                    <span>/</span>

                    <a
                        href="{{ route(
                            'knowledgebase.category',
                            [
                                'knowledgebase' =>
                                    $knowledgebase[
                                        'slug'
                                    ],

                                'category' =>
                                    $article
                                        ->category
                                        ->slug,
                            ]
                        ) }}"
                        class="
                            no-underline
                            text-rino-muted
                        "
                    >
                        {{ $article->category->name }}
                    </a>
                @endif

                <span>/</span>

                <span
                    class="
                        min-w-0
                        truncate
                    "
                >
                    {{ $article->title }}
                </span>
            </nav>

            <div
                class="
                    mt-9
                    grid
                    gap-10
                    lg:grid-cols-[minmax(0,7fr)_minmax(260px,3fr)]
                    xl:gap-14
                "
            >
                <div class="min-w-0">
                    <header
                        class="
                            max-w-4xl
                        "
                    >
                        <h1
                            class="
                                text-[2rem]
                                font-bold
                                leading-[1.12]
                                tracking-tight
                                text-rino-heading
                                sm:text-[2.35rem]
                                lg:text-[2.6rem]
                            "
                        >
                            {{ $article->title }}
                        </h1>

                        @if (
                            filled(
                                $article
                                    ->short_description
                            )
                        )
                            <p
                                class="
                                    mt-4
                                    max-w-3xl
                                    text-base
                                    leading-[1.7]
                                    text-rino-muted
                                "
                            >
                                {{ $article->short_description }}
                            </p>
                        @endif

                        <p
                            class="
                                mt-4
                                text-sm
                                text-rino-muted
                            "
                        >
                            Updated
                            {{ $article->updated_at->format(
                                'M j, Y'
                            ) }}
                        </p>
                    </header>

                    <div
                        class="
                            kb-content
                            mt-10
                            max-w-none
                            text-[0.9375rem]
                            leading-[1.8]
                            text-rino-body

                            [&>*:first-child]:mt-0
                            [&>*:last-child]:mb-0

                            [&_a]:font-medium
                            [&_a]:text-rino-primary
                            [&_a]:underline
                            [&_a]:underline-offset-4

                            [&_blockquote]:my-6
                            [&_blockquote]:border-l-4
                            [&_blockquote]:border-rino-primary
                            [&_blockquote]:pl-5
                            [&_blockquote]:text-rino-muted

                            [&_code]:rounded
                            [&_code]:bg-rino-surface
                            [&_code]:px-1.5
                            [&_code]:py-0.5
                            [&_code]:font-mono
                            [&_code]:text-[0.875em]
                            [&_code]:text-rino-heading

                            [&_em]:italic

                            [&_h1]:mb-4
                            [&_h1]:mt-10
                            [&_h1]:text-[2rem]
                            [&_h1]:font-bold
                            [&_h1]:leading-tight
                            [&_h1]:tracking-tight
                            [&_h1]:text-rino-heading

                            [&_h2]:mb-3
                            [&_h2]:mt-9
                            [&_h2]:text-[1.625rem]
                            [&_h2]:font-bold
                            [&_h2]:leading-tight
                            [&_h2]:tracking-tight
                            [&_h2]:text-rino-heading

                            [&_h3]:mb-3
                            [&_h3]:mt-8
                            [&_h3]:text-[1.25rem]
                            [&_h3]:font-bold
                            [&_h3]:leading-snug
                            [&_h3]:text-rino-heading

                            [&_h4]:mb-2
                            [&_h4]:mt-7
                            [&_h4]:text-lg
                            [&_h4]:font-bold
                            [&_h4]:text-rino-heading

                            [&_hr]:my-8
                            [&_hr]:border-0
                            [&_hr]:border-t
                            [&_hr]:border-rino-border

                            [&_img]:my-7
                            [&_img]:h-auto
                            [&_img]:max-w-full
                            [&_img]:rounded-[var(--radius-card)]

                            [&_li]:my-1.5

                            [&_ol]:my-5
                            [&_ol]:list-decimal
                            [&_ol]:pl-6

                            [&_p]:my-4
                            [&_p]:leading-[1.8]

                            [&_pre]:my-6
                            [&_pre]:overflow-x-auto
                            [&_pre]:rounded-[var(--radius-card)]
                            [&_pre]:bg-rino-surface
                            [&_pre]:p-5
                            [&_pre]:font-mono
                            [&_pre]:text-sm
                            [&_pre]:leading-[1.7]
                            [&_pre]:text-rino-body
                            [&_pre_code]:bg-transparent
                            [&_pre_code]:p-0

                            [&_strong]:font-bold
                            [&_strong]:text-rino-heading

                            [&_table]:my-7
                            [&_table]:w-full
                            [&_table]:border-collapse
                            [&_table]:overflow-hidden
                            [&_table]:rounded-[var(--radius-card)]

                            [&_td]:border
                            [&_td]:border-rino-border
                            [&_td]:px-4
                            [&_td]:py-3
                            [&_td]:align-top

                            [&_th]:border
                            [&_th]:border-rino-border
                            [&_th]:bg-rino-surface
                            [&_th]:px-4
                            [&_th]:py-3
                            [&_th]:text-left
                            [&_th]:font-bold
                            [&_th]:text-rino-heading

                            [&_ul]:my-5
                            [&_ul]:list-disc
                            [&_ul]:pl-6
                        "
                    >
                        {!! $article->content !!}
                    </div>
                </div>

                <aside
                    class="
                        min-w-0
                    "
                >
                    <div
                        class="
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            p-5
                            ring-1
                            ring-inset
                            ring-black/5
                            lg:sticky
                            lg:top-28
                        "
                    >
                        <h2
                            class="
                                text-base
                                font-bold
                                text-rino-heading
                            "
                        >
                            More articles
                        </h2>

                        @if (
                            $related->isNotEmpty()
                        )
                            <div
                                class="
                                    mt-4
                                    flex
                                    flex-col
                                    gap-2
                                "
                            >
                                @foreach (
                                    $related
                                    as $relatedArticle
                                )
                                    <a
                                        href="{{ route(
                                            'knowledgebase.show',
                                            [
                                                'knowledgebase' =>
                                                    $knowledgebase[
                                                        'slug'
                                                    ],

                                                'article' =>
                                                    $relatedArticle
                                                        ->slug,
                                            ]
                                        ) }}"
                                        class="
                                            flex
                                            items-start
                                            gap-3
                                            rounded-[var(--radius-button)]
                                            bg-rino-surface-secondary
                                            p-3
                                            no-underline
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

                                        <span
                                            class="
                                                min-w-0
                                                text-sm
                                                font-medium
                                                leading-snug
                                                text-rino-body
                                            "
                                        >
                                            {{ $relatedArticle->title }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p
                                class="
                                    mt-3
                                    text-sm
                                    leading-relaxed
                                    text-rino-muted
                                "
                            >
                                No more articles in this category yet.
                            </p>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </article>
@endsection
