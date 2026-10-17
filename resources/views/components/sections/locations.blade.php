@php
    use App\Support\LocationPresets;

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
        ?? 'map-list';

    $heading =
        $section['heading']
        ?? '';

    $description =
        $section['description']
        ?? null;

    $items =
        is_array(
            $section['locations']
            ?? null
        )
            ? $section['locations']
            : [];

    $locations =
        collect($items)
            ->filter(
                fn ($item): bool =>
                    is_array($item)
                    &&
                    ($item['enabled'] ?? true)
                    &&
                    filled(
                        $item['location']
                        ?? null
                    )
                    &&
                    LocationPresets::exists(
                        $item['location']
                    )
            )
            ->values()
            ->all();

    $isCentered =
        $alignment === 'center';

    $showList =
        $layout === 'map-list';
@endphp

<section
    class="
        relative
        overflow-hidden
        py-16
        sm:py-20
        lg:py-24
    "
>
    <div
        class="
            mx-auto
            w-full
            max-w-7xl
            px-4
            sm:px-6
            lg:px-8
        "
    >
        @if (
            filled($heading)
            ||
            filled($description)
        )
            <div
                class="
                    mb-10
                    max-w-3xl
                    sm:mb-12
                    {{ $isCentered
                        ? 'mx-auto text-center'
                        : 'text-left'
                    }}
                "
            >
                @if (filled($heading))
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

                @if (filled($description))
                    <p
                        class="
                            mt-4
                            max-w-2xl
                            text-[0.9375rem]
                            leading-[1.7]
                            text-rino-muted
                            sm:text-[1rem]
                            {{ $isCentered
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

        @if ($showList)
            <div
                class="
                    grid
                    grid-cols-1
                    items-start
                    gap-8
                    lg:grid-cols-[320px_minmax(0,1fr)]
                    lg:gap-10
                    xl:grid-cols-[340px_minmax(0,1fr)]
                    xl:gap-12
                "
            >
                <div
                    class="
                        grid
                        min-w-0
                        content-start
                        gap-3
                        self-start
                        sm:grid-cols-2
                        lg:grid-cols-1
                    "
                >
                    @foreach ($locations as $item)
                        @php
                            $key =
                                $item['location'];

                            $label =
                                trim(
                                    (string) (
                                        $item['label']
                                        ?? ''
                                    )
                                );

                            if ($label === '') {
                                $label =
                                    LocationPresets::label(
                                        $key
                                    )
                                    ?? '';
                            }

                            $flag =
                                LocationPresets::flag(
                                    $key
                                );

                            $status =
                                $item['status']
                                ?? 'available';

                            $statusLabel =
                                match ($status) {
                                    'limited' =>
                                        'Limited',

                                    'coming-soon' =>
                                        'Coming Soon',

                                    default =>
                                        'Available',
                                };
                        @endphp

                        <article
                            class="
                                flex
                                min-w-0
                                items-center
                                gap-3
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                px-4
                                py-3.5
                                ring-1
                                ring-inset
                                ring-black/5
                            "
                        >
                            @if ($flag)
                                <div
                                    class="
                                        flex
                                        h-[2rem]
                                        w-[2.75rem]
                                        shrink-0
                                        items-center
                                        justify-center
                                        overflow-hidden
                                        rounded-md
                                        bg-rino-surface-secondary
                                    "
                                >
                                    <img
                                        src="{{ $flag }}"
                                        alt=""
                                        class="
                                            h-full
                                            w-full
                                            object-cover
                                        "
                                    >
                                </div>
                            @endif

                            <div
                                class="
                                    min-w-0
                                    flex-1
                                "
                            >
                                <div
                                    class="
                                        truncate
                                        text-[0.9375rem]
                                        font-semibold
                                        text-rino-heading
                                    "
                                >
                                    {{ $label }}
                                </div>

                                <div
                                    class="
                                        mt-1
                                        flex
                                        flex-wrap
                                        items-center
                                        gap-x-2
                                        gap-y-1
                                        text-[0.8125rem]
                                        text-rino-muted
                                    "
                                >
                                    <span>
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>

                            <span
                                class="
                                    inline-flex
                                    h-[1.125rem]
                                    w-[1.25rem]
                                    shrink-0
                                    items-end
                                    justify-center
                                    gap-[2px]
                                    text-rino-muted
                                "
                                aria-label="{{ $statusLabel }}"
                                title="{{ $statusLabel }}"
                            >
                                <span
                                    class="
                                        block
                                        h-[0.35rem]
                                        w-[3px]
                                        rounded-full
                                        bg-current
                                        opacity-45
                                    "
                                ></span>

                                <span
                                    class="
                                        block
                                        h-[0.55rem]
                                        w-[3px]
                                        rounded-full
                                        bg-current
                                        opacity-60
                                    "
                                ></span>

                                <span
                                    class="
                                        block
                                        h-[0.78rem]
                                        w-[3px]
                                        rounded-full
                                        bg-current
                                        opacity-75
                                    "
                                ></span>

                                <span
                                    class="
                                        block
                                        h-[1rem]
                                        w-[3px]
                                        rounded-full
                                        bg-current
                                        opacity-90
                                    "
                                ></span>
                            </span>
                        </article>
                    @endforeach
                </div>

                <div
                    class="
                        min-w-0
                        self-start
                        rounded-[var(--radius-card)]
                        bg-rino-surface
                        p-4
                        ring-1
                        ring-inset
                        ring-black/5
                        sm:p-5
                        lg:p-6
                    "
                >
                    <div
                        class="
                            mx-auto
                            w-full
                            max-w-[860px]
                        "
                    >
                        @include(
                            'components.sections.partials.world-map',
                            [
                                'locations' =>
                                    $locations,
                            ]
                        )
                    </div>
                </div>
            </div>
        @else
            <div
                class="
                    mx-auto
                    w-full
                    max-w-[980px]
                    rounded-[var(--radius-card)]
                    bg-rino-surface
                    p-4
                    ring-1
                    ring-inset
                    ring-black/5
                    sm:p-5
                    lg:p-6
                "
            >
                @include(
                    'components.sections.partials.world-map',
                    [
                        'locations' =>
                            $locations,
                    ]
                )
            </div>
        @endif
    </div>
</section>