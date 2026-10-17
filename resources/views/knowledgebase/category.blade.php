@extends('layouts.app')

@section(
    'title',
    $category->name
    . ' | '
    . $knowledgebase['title']
    . ' | '
    . $siteName
)

@section('content')
    <section
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
                max-w-5xl
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

                <span>/</span>

                <span>
                    {{ $category->name }}
                </span>
            </nav>

            <header
                class="
                    mx-auto
                    mt-10
                    max-w-2xl
                    text-center
                "
            >
                <h1
                    class="
                        text-[2rem]
                        font-bold
                        leading-tight
                        tracking-tight
                        text-rino-heading
                        sm:text-[2.25rem]
                    "
                >
                    {{ $category->name }}
                </h1>

                @if (
                    filled(
                        $category->description
                    )
                )
                    <p
                        class="
                            mt-4
                            text-[0.9375rem]
                            leading-[1.7]
                            text-rino-muted
                            sm:text-base
                        "
                    >
                        {{ $category->description }}
                    </p>
                @endif
            </header>

            @if (
                $articles->isNotEmpty()
            )
                <div
                    class="
                        mx-auto
                        mt-10
                        flex
                        max-w-3xl
                        flex-col
                        gap-3
                    "
                >
                    @foreach (
                        $articles
                        as $article
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
                                        $article->slug,
                                ]
                            ) }}"
                            class="
                                flex
                                items-start
                                gap-4
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                p-5
                                no-underline
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

                            <span class="min-w-0">
                                <span
                                    class="
                                        block
                                        text-base
                                        font-bold
                                        text-rino-heading
                                    "
                                >
                                    {{ $article->title }}
                                </span>

                                @if (
                                    filled(
                                        $article
                                            ->short_description
                                    )
                                )
                                    <span
                                        class="
                                            mt-2
                                            block
                                            text-sm
                                            leading-[1.65]
                                            text-rino-muted
                                        "
                                    >
                                        {{ $article->short_description }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>

                <div
                    class="
                        mx-auto
                        mt-8
                        max-w-3xl
                    "
                >
                    {{ $articles->links() }}
                </div>
            @else
                <div
                    class="
                        mx-auto
                        mt-10
                        max-w-3xl
                        rounded-[var(--radius-card)]
                        bg-rino-surface
                        p-8
                        text-center
                    "
                >
                    <p class="text-rino-muted">
                        No articles are available in this category yet.
                    </p>
                </div>
            @endif
        </div>
    </section>
@endsection
