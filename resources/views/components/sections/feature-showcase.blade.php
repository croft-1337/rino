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
        ?? 'left';

    $layout =
        $section['layout']
        ?? 'cards-left';

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

    $items =
        is_array(
            $section['showcases']
            ?? null
        )
            ? $section['showcases']
            : [];

    $showcases =
        collect($items)
            ->filter(
                fn ($item): bool =>
                    is_array($item)
                    &&
                    ($item['enabled'] ?? true)
                    &&
                    filled($item['title'] ?? null)
                    &&
                    filled($item['visual'] ?? null)
            )
            ->values()
            ->all();

    if (count($showcases) === 0) {
        return;
    }

    $isCentered =
        $alignment === 'center';

    $cardsRight =
        $layout === 'cards-right';

    $resolveVisual = function ($value): ?string {
        if (is_array($value)) {
            $value =
                collect($value)
                    ->filter()
                    ->first();
        }

        $path =
            trim(
                (string) (
                    $value
                    ?? ''
                )
            );

        if ($path === '') {
            return null;
        }

        if (
            str_starts_with($path, 'http://')
            ||
            str_starts_with($path, 'https://')
            ||
            str_starts_with($path, '/')
        ) {
            return $path;
        }

        return \App\Support\AssetUrl::resolve($path);
    };
@endphp

<section
    class="
        relative
        overflow-hidden
        py-16
        sm:py-20
        lg:py-24
    "
    data-rino-feature-showcase
>
    <div
        class="
            mx-auto
            w-full
            max-w-none
            px-4
            sm:px-5
            {{ $cardsRight
                ? 'lg:pl-2 lg:pr-5 xl:pl-1 xl:pr-6'
                : 'lg:pl-5 lg:pr-2 xl:pl-6 xl:pr-1'
            }}
        "
    >
        @if ($heading !== '' || $description !== '')
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

        <div
            class="
                grid
                grid-cols-1
                gap-6
                {{ $cardsRight
                    ? 'lg:grid-cols-[minmax(0,1.18fr)_minmax(0,0.82fr)]'
                    : 'lg:grid-cols-[minmax(0,0.82fr)_minmax(0,1.18fr)]'
                }}
                lg:gap-5
                xl:gap-6
            "
        >
            <div
                class="
                    min-w-0
                    space-y-3
                    {{ $cardsRight
                        ? 'lg:order-2'
                        : 'lg:order-1'
                    }}
                "
                role="tablist"
                aria-label="Feature showcase"
            >
                @foreach ($showcases as $index => $item)
                    @php
                        $title =
                            trim(
                                (string) (
                                    $item['title']
                                    ?? ''
                                )
                            );

                        $text =
                            trim(
                                (string) (
                                    $item['description']
                                    ?? ''
                                )
                            );

                        $icon =
                            $item['icon']
                            ?? null;

                        $isActive =
                            $index === 0;
                    @endphp

                    <button
                        type="button"
                        class="
                            group
                            relative
                            flex
                            w-full
                            items-start
                            gap-4
                            overflow-hidden
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            px-5
                            py-5
                            text-left
                            transition-[box-shadow]
                            duration-150
                            ring-1
                            ring-inset
                            ring-black/5
                            sm:px-6
                            sm:py-6
                            {{ $isActive
                                ? 'ring-rino-primary'
                                : ''
                            }}
                        "
                        data-rino-showcase-tab
                        data-index="{{ $index }}"
                        role="tab"
                        aria-selected="{{ $isActive ? 'true' : 'false' }}"
                    >
                        @if ($icon)
                            <span
                                class="
                                    mt-0.5
                                    inline-flex
                                    h-11
                                    w-11
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-lg
                                    bg-rino-primary
                                    text-rino-primary-text
                                "
                            >
                                <x-sections.partials.feature-icon
                                    :name="$icon"
                                    class="
                                        size-[1.35rem]
                                        sm:size-6
                                    "
                                />
                            </span>
                        @endif

                        <span class="min-w-0 flex-1">
                            <span
                                class="
                                    block
                                    text-[1.05rem]
                                    font-semibold
                                    text-rino-heading
                                    sm:text-[1.125rem]
                                "
                            >
                                {{ $title }}
                            </span>

                            @if ($text !== '')
                                <span
                                    class="
                                        mt-2
                                        block
                                        text-[0.9375rem]
                                        leading-[1.65]
                                        text-rino-muted
                                    "
                                >
                                    {{ $text }}
                                </span>
                            @endif
                        </span>

                        <span
                            class="
                                pointer-events-none
                                absolute
                                right-0
                                top-0
                                h-0
                                w-0
                                border-l-[2.5rem]
                                border-t-[2.5rem]
                                border-l-transparent
                                border-t-rino-primary
                                {{ $isActive
                                    ? 'block'
                                    : 'hidden'
                                }}
                            "
                            data-rino-showcase-corner
                            aria-hidden="true"
                        ></span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="
                                pointer-events-none
                                absolute
                                right-[0.3rem]
                                top-[0.3rem]
                                h-4
                                w-4
                                text-rino-primary-text
                                {{ $isActive
                                    ? 'block'
                                    : 'hidden'
                                }}
                            "
                            data-rino-showcase-check
                            aria-hidden="true"
                        >
                            <path d="m5 12 4 4L19 6"/>
                        </svg>
                    </button>
                @endforeach
            </div>

            <div
                class="
                    min-w-0
                    {{ $cardsRight
                        ? 'lg:order-1'
                        : 'lg:order-2'
                    }}
                "
            >
                <div
                    class="
                        relative
                        w-full
                        overflow-hidden
                        rounded-[var(--radius-card)]
                        p-[3px]
                    "
                    style="
                        background:
                            {{ $cardsRight
                                ? 'linear-gradient(
                                    90deg,
                                    transparent 0%,
                                    color-mix(
                                        in srgb,
                                        var(--border) 35%,
                                        transparent
                                    ) 32%,
                                    color-mix(
                                        in srgb,
                                        var(--border) 78%,
                                        transparent
                                    ) 62%,
                                    var(--border) 100%
                                )'
                                : 'linear-gradient(
                                    90deg,
                                    var(--border) 0%,
                                    color-mix(
                                        in srgb,
                                        var(--border) 78%,
                                        transparent
                                    ) 38%,
                                    color-mix(
                                        in srgb,
                                        var(--border) 35%,
                                        transparent
                                    ) 68%,
                                    transparent 100%
                                )'
                            }};
                    "
                >
                    <div
                        class="
                            relative
                            aspect-[16/10]
                            overflow-hidden
                            rounded-[calc(var(--radius-card)-3px)]
                            bg-rino-background
                        "
                    >
                        @foreach ($showcases as $index => $item)
                            @php
                                $visual =
                                    $resolveVisual(
                                        $item['visual']
                                        ?? null
                                    );
                            @endphp

                            <div
                                class="
                                    absolute
                                    inset-0
                                    transition-opacity
                                    duration-200
                                    {{ $index === 0
                                        ? 'pointer-events-auto opacity-100'
                                        : 'pointer-events-none opacity-0'
                                    }}
                                "
                                data-rino-showcase-panel
                                data-index="{{ $index }}"
                                role="tabpanel"
                            >
                                @if ($visual)
                                    <img
                                        src="{{ $visual }}"
                                        alt="{{ $item['title'] ?? '' }}"
                                        class="
                                            h-full
                                            w-full
                                            object-cover
                                            object-center
                                        "
                                        loading="lazy"
                                    >
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@once
    <script>
        (() => {
            const initFeatureShowcases = () => {
                document
                    .querySelectorAll(
                        '[data-rino-feature-showcase]'
                    )
                    .forEach((section) => {
                        if (
                            section.dataset
                                .rinoFeatureShowcaseReady ===
                            'true'
                        ) {
                            return;
                        }

                        section.dataset
                            .rinoFeatureShowcaseReady =
                            'true';

                        const tabs =
                            Array.from(
                                section.querySelectorAll(
                                    '[data-rino-showcase-tab]'
                                )
                            );

                        const panels =
                            Array.from(
                                section.querySelectorAll(
                                    '[data-rino-showcase-panel]'
                                )
                            );

                        const activate = (index) => {
                            tabs.forEach((tab) => {
                                const active =
                                    tab.dataset.index ===
                                    index;

                                tab.setAttribute(
                                    'aria-selected',
                                    active
                                        ? 'true'
                                        : 'false'
                                );

                                tab.classList.toggle(
                                    'ring-rino-primary',
                                    active
                                );

                                const corner =
                                    tab.querySelector(
                                        '[data-rino-showcase-corner]'
                                    );

                                const check =
                                    tab.querySelector(
                                        '[data-rino-showcase-check]'
                                    );

                                if (corner) {
                                    corner.classList.toggle(
                                        'hidden',
                                        !active
                                    );

                                    corner.classList.toggle(
                                        'block',
                                        active
                                    );
                                }

                                if (check) {
                                    check.classList.toggle(
                                        'hidden',
                                        !active
                                    );

                                    check.classList.toggle(
                                        'block',
                                        active
                                    );
                                }
                            });

                            panels.forEach((panel) => {
                                const active =
                                    panel.dataset.index ===
                                    index;

                                panel.classList.toggle(
                                    'opacity-100',
                                    active
                                );

                                panel.classList.toggle(
                                    'opacity-0',
                                    !active
                                );

                                panel.classList.toggle(
                                    'pointer-events-auto',
                                    active
                                );

                                panel.classList.toggle(
                                    'pointer-events-none',
                                    !active
                                );
                            });
                        };

                        tabs.forEach((tab) => {
                            tab.addEventListener(
                                'click',
                                () => {
                                    activate(
                                        tab.dataset.index
                                    );
                                }
                            );
                        });
                    });
            };

            if (
                document.readyState ===
                'loading'
            ) {
                document.addEventListener(
                    'DOMContentLoaded',
                    initFeatureShowcases
                );
            } else {
                initFeatureShowcases();
            }

            document.addEventListener(
                'livewire:navigated',
                initFeatureShowcases
            );
        })();
    </script>
@endonce