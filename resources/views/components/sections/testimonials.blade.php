@php
    use Illuminate\Support\Facades\Storage;

    $enabled =
        $section['enabled']
        ?? true;

    if (!$enabled) {
        return;
    }

    $alignment =
        $section['alignment']
        ?? 'center';

    $layout =
        $section['layout']
        ?? 'grid';

    $heading =
        trim(
            (string) (
                $section['heading']
                ?? ''
            )
        );

    $description =
        trim(
            (string) (
                $section['description']
                ?? ''
            )
        );

    $rawItems =
        is_array(
            $section['testimonials']
            ?? null
        )
            ? $section['testimonials']
            : [];

    $testimonials =
        collect($rawItems)
            ->filter(
                fn ($item): bool =>
                    is_array($item)
                    &&
                    ($item['enabled'] ?? true)
                    &&
                    filled($item['name'] ?? null)
                    &&
                    filled($item['quote'] ?? null)
            )
            ->values();

    if ($testimonials->isEmpty()) {
        return;
    }

    $centered =
        $alignment === 'center';

    
$resolveAvatar = function ($value): ?string {
    if (is_array($value)) {
        $value = collect($value)
            ->filter()
            ->first();
    }

    return \App\Support\AssetUrl::resolve(
        is_string($value) ? $value : null
    );
};


    $initials = function (string $name): string {
        return collect(
            preg_split(
                '/\s+/',
                trim($name)
            )
        )
            ->filter()
            ->take(2)
            ->map(
                fn ($part) =>
                    mb_strtoupper(
                        mb_substr(
                            $part,
                            0,
                            1
                        )
                    )
            )
            ->implode('');
    };
@endphp

<section
    class="
        bg-rino-background
        px-4
        py-16
        sm:px-6
        sm:py-20
        lg:px-8
        lg:py-24
    "
>
    <div
        class="
            mx-auto
            w-full
            max-w-7xl
        "
    >
        @if ($heading !== '' || $description !== '')
            <div
                class="
                    mb-10
                    max-w-3xl
                    sm:mb-12
                    {{ $centered
                        ? 'mx-auto text-center'
                        : ''
                    }}
                "
            >
                @if ($heading !== '')
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
                        {{ $heading }}
                    </h2>
                @endif

                @if ($description !== '')
                    <p
                        class="
                            mt-4
                            max-w-2xl
                            text-[0.9375rem]
                            leading-[1.7]
                            text-rino-muted
                            sm:text-[1rem]
                            {{ $centered
                                ? 'mx-auto'
                                : ''
                            }}
                        "
                    >
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        @if ($layout === 'featured')
            @php
                $featured =
                    $testimonials->first();

                $secondary =
                    $testimonials
                        ->slice(1, 4)
                        ->values();

                $remaining =
                    $testimonials
                        ->slice(5)
                        ->values();

                $featuredAvatar =
                    $resolveAvatar(
                        $featured['avatar']
                        ?? null
                    );
            @endphp

            <div
                class="
                    grid
                    grid-cols-1
                    gap-4
                    lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1.8fr)]
                    lg:gap-5
                "
            >
                <article
                    class="
                        flex
                        min-h-[34rem]
                        flex-col
                        justify-between
                        rounded-[var(--radius-card)]
                        bg-rino-surface
                        ring-1
                        ring-inset
                        ring-black/5
                        p-6
                        sm:p-8
                        lg:p-9
                    "
                >
                    <div>
                        @if (!empty($featured['rating']))
                            <div
                                class="
                                    flex
                                    items-center
                                    gap-1
                                    text-rino-primary
                                "
                                aria-label="{{ $featured['rating'] }} out of 5 stars"
                            >
                                @for ($star = 1; $star <= 5; $star++)
                                    <svg
                                        viewBox="0 0 24 24"
                                        class="
                                            h-5
                                            w-5
                                            {{ $star <= (int) $featured['rating']
                                                ? 'fill-current'
                                                : 'fill-rino-muted/25'
                                            }}
                                        "
                                        aria-hidden="true"
                                    >
                                        <path d="m12 2.5 3 6.1 6.7 1-4.9 4.7 1.2 6.7-6-3.2-6 3.2 1.2-6.7-4.9-4.7 6.7-1 3-6.1Z"/>
                                    </svg>
                                @endfor
                            </div>
                        @endif

                        <svg
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="
                                mt-5
                                h-9
                                w-9
                                text-rino-primary/45
                            "
                            aria-hidden="true"
                        >
                            <path d="M6.5 5C4 5 2 7 2 9.5V14h5v5h5v-9.5C12 7 10 5 7.5 5h-1Zm10 0C14 5 12 7 12 9.5V14h5v5h5v-9.5C22 7 20 5 17.5 5h-1Z"/>
                        </svg>

                        <blockquote
                            class="
                                mt-6
                                text-[1.15rem]
                                font-medium
                                leading-[1.75]
                                text-rino-heading
                                sm:text-[1.25rem]
                            "
                        >
                            “{{ $featured['quote'] }}”
                        </blockquote>
                    </div>

                    <div
                        class="
                            mt-10
                            border-t
                            border-rino-border/40
                            pt-5
                        "
                    >
                        <div
                            class="
                                flex
                                items-center
                                gap-3
                            "
                        >
                            @if ($featuredAvatar)
                                <img
                                    src="{{ $featuredAvatar }}"
                                    alt="{{ $featured['name'] }}"
                                    class="
                                        h-12
                                        w-12
                                        rounded-full
                                        object-cover
                                    "
                                    loading="lazy"
                                >
                            @else
                                <span
                                    class="
                                        flex
                                        h-12
                                        w-12
                                        shrink-0
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-rino-primary
                                        text-sm
                                        font-bold
                                        text-rino-primary-text
                                    "
                                >
                                    {{ $initials((string) $featured['name']) }}
                                </span>
                            @endif

                            <div class="min-w-0">
                                <div
                                    class="
                                        truncate
                                        text-[0.95rem]
                                        font-semibold
                                        text-rino-heading
                                    "
                                >
                                    {{ $featured['name'] }}
                                </div>

                                @if (filled($featured['role'] ?? null))
                                    <div
                                        class="
                                            mt-0.5
                                            truncate
                                            text-[0.8125rem]
                                            text-rino-muted
                                        "
                                    >
                                        {{ $featured['role'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>

                <div
                    class="
                        grid
                        grid-cols-1
                        gap-4
                        sm:grid-cols-2
                    "
                >
                    @foreach ($secondary as $item)
                        @php
                            $avatar =
                                $resolveAvatar(
                                    $item['avatar']
                                    ?? null
                                );
                        @endphp

                        <article
                            class="
                                flex
                                min-h-[16.5rem]
                                flex-col
                                justify-between
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                ring-1
                                ring-inset
                                ring-black/5
                                p-5
                                sm:p-6
                            "
                        >
                            <div>
                                @if (!empty($item['rating']))
                                    <div
                                        class="
                                            flex
                                            items-center
                                            gap-1
                                            text-rino-primary
                                        "
                                        aria-label="{{ $item['rating'] }} out of 5 stars"
                                    >
                                        @for ($star = 1; $star <= 5; $star++)
                                            <svg
                                                viewBox="0 0 24 24"
                                                class="
                                                    h-4
                                                    w-4
                                                    {{ $star <= (int) $item['rating']
                                                        ? 'fill-current'
                                                        : 'fill-rino-muted/25'
                                                    }}
                                                "
                                                aria-hidden="true"
                                            >
                                                <path d="m12 2.5 3 6.1 6.7 1-4.9 4.7 1.2 6.7-6-3.2-6 3.2 1.2-6.7-4.9-4.7 6.7-1 3-6.1Z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif

                                <blockquote
                                    class="
                                        mt-5
                                        text-[0.95rem]
                                        leading-[1.7]
                                        text-rino-body
                                    "
                                >
                                    “{{ $item['quote'] }}”
                                </blockquote>
                            </div>

                            <div
                                class="
                                    mt-6
                                    border-t
                                    border-rino-border/40
                                    pt-4
                                "
                            >
                                <div
                                    class="
                                        flex
                                        items-center
                                        gap-3
                                    "
                                >
                                    @if ($avatar)
                                        <img
                                            src="{{ $avatar }}"
                                            alt="{{ $item['name'] }}"
                                            class="
                                                h-10
                                                w-10
                                                rounded-full
                                                object-cover
                                            "
                                            loading="lazy"
                                        >
                                    @else
                                        <span
                                            class="
                                                flex
                                                h-10
                                                w-10
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-rino-primary
                                                text-xs
                                                font-bold
                                                text-rino-primary-text
                                            "
                                        >
                                            {{ $initials((string) $item['name']) }}
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <div
                                            class="
                                                truncate
                                                text-[0.9rem]
                                                font-semibold
                                                text-rino-heading
                                            "
                                        >
                                            {{ $item['name'] }}
                                        </div>

                                        @if (filled($item['role'] ?? null))
                                            <div
                                                class="
                                                    mt-0.5
                                                    truncate
                                                    text-[0.78rem]
                                                    text-rino-muted
                                                "
                                            >
                                                {{ $item['role'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            @if ($remaining->isNotEmpty())
                <div
                    class="
                        mt-4
                        grid
                        grid-cols-1
                        gap-4
                        md:grid-cols-2
                        xl:grid-cols-3
                    "
                >
                    @foreach ($remaining as $item)
                        @php
                            $avatar =
                                $resolveAvatar(
                                    $item['avatar']
                                    ?? null
                                );
                        @endphp

                        <article
                            class="
                                flex
                                min-h-[16rem]
                                flex-col
                                justify-between
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                ring-1
                                ring-inset
                                ring-black/5
                                p-5
                                sm:p-6
                            "
                        >
                            <div>
                                @if (!empty($item['rating']))
                                    <div
                                        class="
                                            flex
                                            items-center
                                            gap-1
                                            text-rino-primary
                                        "
                                        aria-label="{{ $item['rating'] }} out of 5 stars"
                                    >
                                        @for ($star = 1; $star <= 5; $star++)
                                            <svg
                                                viewBox="0 0 24 24"
                                                class="
                                                    h-4
                                                    w-4
                                                    {{ $star <= (int) $item['rating']
                                                        ? 'fill-current'
                                                        : 'fill-rino-muted/25'
                                                    }}
                                                "
                                                aria-hidden="true"
                                            >
                                                <path d="m12 2.5 3 6.1 6.7 1-4.9 4.7 1.2 6.7-6-3.2-6 3.2 1.2-6.7-4.9-4.7 6.7-1 3-6.1Z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif

                                <blockquote
                                    class="
                                        mt-5
                                        text-[0.95rem]
                                        leading-[1.7]
                                        text-rino-body
                                    "
                                >
                                    “{{ $item['quote'] }}”
                                </blockquote>
                            </div>

                            <div
                                class="
                                    mt-6
                                    border-t
                                    border-rino-border/40
                                    pt-4
                                "
                            >
                                <div
                                    class="
                                        flex
                                        items-center
                                        gap-3
                                    "
                                >
                                    @if ($avatar)
                                        <img
                                            src="{{ $avatar }}"
                                            alt="{{ $item['name'] }}"
                                            class="
                                                h-10
                                                w-10
                                                rounded-full
                                                object-cover
                                            "
                                            loading="lazy"
                                        >
                                    @else
                                        <span
                                            class="
                                                flex
                                                h-10
                                                w-10
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-rino-primary
                                                text-xs
                                                font-bold
                                                text-rino-primary-text
                                            "
                                        >
                                            {{ $initials((string) $item['name']) }}
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <div
                                            class="
                                                truncate
                                                text-[0.9rem]
                                                font-semibold
                                                text-rino-heading
                                            "
                                        >
                                            {{ $item['name'] }}
                                        </div>

                                        @if (filled($item['role'] ?? null))
                                            <div
                                                class="
                                                    mt-0.5
                                                    truncate
                                                    text-[0.78rem]
                                                    text-rino-muted
                                                "
                                            >
                                                {{ $item['role'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        @else
            <div
                class="
                    grid
                    grid-cols-1
                    gap-4
                    md:grid-cols-2
                    xl:grid-cols-3
                "
            >
                @foreach ($testimonials as $item)
                    @php
                        $avatar =
                            $resolveAvatar(
                                $item['avatar']
                                ?? null
                            );
                    @endphp

                    <article
                        class="
                            flex
                            min-h-[17rem]
                            flex-col
                            justify-between
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            ring-1
                            ring-inset
                            ring-black/5
                            p-5
                            sm:p-6
                        "
                    >
                        <div>
                            @if (!empty($item['rating']))
                                <div
                                    class="
                                        flex
                                        items-center
                                        gap-1
                                        text-rino-primary
                                    "
                                    aria-label="{{ $item['rating'] }} out of 5 stars"
                                >
                                    @for ($star = 1; $star <= 5; $star++)
                                        <svg
                                            viewBox="0 0 24 24"
                                            class="
                                                h-4
                                                w-4
                                                {{ $star <= (int) $item['rating']
                                                    ? 'fill-current'
                                                    : 'fill-rino-muted/25'
                                                }}
                                            "
                                            aria-hidden="true"
                                        >
                                            <path d="m12 2.5 3 6.1 6.7 1-4.9 4.7 1.2 6.7-6-3.2-6 3.2 1.2-6.7-4.9-4.7 6.7-1 3-6.1Z"/>
                                        </svg>
                                    @endfor
                                </div>
                            @endif

                            <blockquote
                                class="
                                    mt-5
                                    text-[0.95rem]
                                    leading-[1.75]
                                    text-rino-body
                                "
                            >
                                “{{ $item['quote'] }}”
                            </blockquote>
                        </div>

                        <div
                            class="
                                mt-6
                                border-t
                                border-rino-border/40
                                pt-4
                            "
                        >
                            <div
                                class="
                                    flex
                                    items-center
                                    gap-3
                                "
                            >
                                @if ($avatar)
                                    <img
                                        src="{{ $avatar }}"
                                        alt="{{ $item['name'] }}"
                                        class="
                                            h-11
                                            w-11
                                            rounded-full
                                            object-cover
                                        "
                                        loading="lazy"
                                    >
                                @else
                                    <span
                                        class="
                                            flex
                                            h-11
                                            w-11
                                            shrink-0
                                            items-center
                                            justify-center
                                            rounded-full
                                            bg-rino-primary
                                            text-xs
                                            font-bold
                                            text-rino-primary-text
                                        "
                                    >
                                        {{ $initials((string) $item['name']) }}
                                    </span>
                                @endif

                                <div class="min-w-0">
                                    <div
                                        class="
                                            truncate
                                            text-[0.9rem]
                                            font-semibold
                                            text-rino-heading
                                        "
                                    >
                                        {{ $item['name'] }}
                                    </div>

                                    @if (filled($item['role'] ?? null))
                                        <div
                                            class="
                                                mt-0.5
                                                truncate
                                                text-[0.8rem]
                                                text-rino-muted
                                            "
                                        >
                                            {{ $item['role'] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>