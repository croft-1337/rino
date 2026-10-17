@php
    $documentLayout =
        $page->document_layout
        ?? \App\Models\Page::DOCUMENT_LAYOUT_LEFT;

    $isCentered =
        $documentLayout ===
        \App\Models\Page::DOCUMENT_LAYOUT_CENTERED;
@endphp

<section
    class="
        bg-rino-background
        px-4
        py-14
        sm:px-6
        sm:py-16
        lg:px-8
        lg:py-20
    "
>
    <div
        class="
            mx-auto
            w-full
            max-w-7xl
        "
    >
        <div
            class="
                w-full
                max-w-[900px]
                {{ $isCentered
                    ? 'mx-auto'
                    : ''
                }}
            "
        >
            <header
                class="
                    {{ $isCentered
                        ? 'text-center'
                        : 'text-left'
                    }}
                "
            >
                <h1
                    class="
                        text-[2rem]
                        font-bold
                        leading-[1.15]
                        tracking-tight
                        text-rino-heading
                        sm:text-[2.25rem]
                        lg:text-[2.5rem]
                    "
                >
                    {{ $page->title }}
                </h1>

                @if ($page->short_description)
                    <p
                        class="
                            mt-4
                            text-[0.9375rem]
                            leading-[1.7]
                            text-rino-muted
                            sm:text-[1rem]
                            {{ $isCentered
                                ? 'mx-auto max-w-2xl'
                                : 'max-w-2xl'
                            }}
                        "
                    >
                        {{ $page->short_description }}
                    </p>
                @endif

                @if ($page->document_updated_at)
                    <p
                        class="
                            mt-3
                            text-[0.75rem]
                            font-medium
                            text-rino-muted
                        "
                    >
                        Last updated:
                        {{ $page->document_updated_at->format('F j, Y') }}
                    </p>
                @endif
            </header>

            <div
                class="
                    rino-document
                    mt-10
                    sm:mt-12
                "
            >
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>

<style>
    .rino-document {
        width: 100%;
        color: var(--text-body);
        font-size: 0.9375rem;
        line-height: 1.75;
        text-align: left;
    }

    .rino-document > *:first-child {
        margin-top: 0;
    }

    .rino-document > *:last-child {
        margin-bottom: 0;
    }

    .rino-document h1,
    .rino-document h2,
    .rino-document h3,
    .rino-document h4,
    .rino-document h5,
    .rino-document h6 {
        color: var(--text-heading);
        font-family: var(--font-heading);
        font-weight: 700;
        letter-spacing: -0.02em;
        text-align: left;
    }

    .rino-document h1 {
        margin-top: 3rem;
        margin-bottom: 1rem;
        font-size: 1.875rem;
        line-height: 1.2;
    }

    .rino-document h2 {
        margin-top: 2.75rem;
        margin-bottom: 0.875rem;
        font-size: 1.45rem;
        line-height: 1.3;
    }

    .rino-document h3 {
        margin-top: 2.25rem;
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
        line-height: 1.35;
    }

    .rino-document h4 {
        margin-top: 2rem;
        margin-bottom: 0.7rem;
        font-size: 1.05rem;
        line-height: 1.4;
    }

    .rino-document h5 {
        margin-top: 1.75rem;
        margin-bottom: 0.65rem;
        font-size: 0.975rem;
        line-height: 1.45;
    }

    .rino-document h6 {
        margin-top: 1.5rem;
        margin-bottom: 0.65rem;
        font-size: 0.9rem;
        line-height: 1.45;
    }

    .rino-document p {
        margin-top: 0.95rem;
        margin-bottom: 0.95rem;
        color: var(--text-body);
        text-align: left;
    }

    .rino-document strong,
    .rino-document b {
        color: var(--text-heading);
        font-weight: 700;
    }

    .rino-document em,
    .rino-document i {
        font-style: italic;
    }

    .rino-document u {
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .rino-document s,
    .rino-document strike {
        text-decoration: line-through;
    }

    .rino-document a {
        color: var(--primary);
        font-weight: 500;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 3px;
        transition: color 150ms ease;
    }

    .rino-document a:hover {
        color: var(--primary-hover);
    }

    .rino-document ul,
    .rino-document ol {
        margin-top: 1rem;
        margin-bottom: 1rem;
        padding-left: 1.5rem;
        text-align: left;
    }

    .rino-document ul {
        list-style-type: disc;
    }

    .rino-document ol {
        list-style-type: decimal;
    }

    .rino-document ul ul {
        list-style-type: circle;
    }

    .rino-document ul ul ul {
        list-style-type: square;
    }

    .rino-document ol ol {
        list-style-type: lower-alpha;
    }

    .rino-document ol ol ol {
        list-style-type: lower-roman;
    }

    .rino-document li {
        margin-top: 0.35rem;
        margin-bottom: 0.35rem;
        padding-left: 0.15rem;
        text-align: left;
    }

    .rino-document li::marker {
        color: var(--text-muted);
    }

    .rino-document blockquote {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 3px solid var(--primary);
        padding: 0.25rem 0 0.25rem 1.125rem;
        color: var(--text-muted);
        text-align: left;
    }

    .rino-document blockquote p {
        margin-top: 0.45rem;
        margin-bottom: 0.45rem;
        color: inherit;
    }

    .rino-document hr {
        margin-top: 2.5rem;
        margin-bottom: 2.5rem;
        border: 0;
        border-top: 1px solid var(--border);
    }

    .rino-document code {
        border-radius: 0.375rem;
        background: var(--surface-secondary);
        padding: 0.15rem 0.4rem;
        color: var(--text-heading);
        font-size: 0.875em;
    }

    .rino-document pre {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        border-radius: var(--radius-card);
        background: var(--surface-secondary);
        padding: 1.125rem 1.25rem;
        text-align: left;
    }

    .rino-document pre code {
        background: transparent;
        padding: 0;
        color: var(--text-body);
        font-size: 0.875rem;
        line-height: 1.7;
    }

    .rino-document table {
        width: 100%;
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
        border-collapse: collapse;
        text-align: left;
    }

    .rino-document th,
    .rino-document td {
        border: 1px solid var(--border);
        padding: 0.75rem 0.875rem;
        text-align: left;
        vertical-align: top;
    }

    .rino-document th {
        background: var(--surface-secondary);
        color: var(--text-heading);
        font-weight: 700;
    }

    .rino-document td {
        color: var(--text-body);
    }

    .rino-document img {
        display: block;
        max-width: 100%;
        height: auto;
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
        border-radius: var(--radius-card);
    }

    .rino-document figure {
        margin-top: 1.75rem;
        margin-bottom: 1.75rem;
    }

    .rino-document figcaption {
        margin-top: 0.75rem;
        color: var(--text-muted);
        font-size: 0.8125rem;
        text-align: left;
    }

    @media (min-width: 640px) {
        .rino-document {
            font-size: 0.9625rem;
        }

        .rino-document h1 {
            font-size: 2rem;
        }

        .rino-document h2 {
            font-size: 1.5rem;
        }

        .rino-document h3 {
            font-size: 1.25rem;
        }
    }
</style>