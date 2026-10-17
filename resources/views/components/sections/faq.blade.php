@php
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
        ?? 'centered';

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

    $ctaEnabled =
        (bool) (
            $section['cta_enabled']
            ?? true
        );

    $ctaLabel =
        trim(
            (string) (
                $section['cta_label']
                ?? ''
            )
        );

    $ctaUrl =
        trim(
            (string) (
                $section['cta_url']
                ?? ''
            )
        );

    $ctaStyle =
        $section['cta_style']
        ?? 'icon-circle';

    $ctaIcon =
        $section['cta_icon']
        ?? 'arrow-right';

    $rawQuestions =
        is_array(
            $section['questions']
            ?? null
        )
            ? $section['questions']
            : [];

    $questions =
        collect($rawQuestions)
            ->filter(
                fn ($item): bool =>
                    is_array($item)
                    &&
                    ($item['enabled'] ?? true)
                    &&
                    filled($item['question'] ?? null)
                    &&
                    filled($item['answer'] ?? null)
            )
            ->values();

    if ($questions->isEmpty()) {
        return;
    }

    $centered =
        $alignment === 'center';
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
        @if ($layout === 'split')
            <div
                class="
                    grid
                    grid-cols-1
                    gap-10
                    lg:grid-cols-[minmax(0,0.72fr)_minmax(0,1.28fr)]
                    lg:gap-14
                    xl:gap-16
                "
            >
                <div
                    class="
                        max-w-xl
                        lg:sticky
                        lg:top-[calc(var(--rino-top-stack-height)+2rem)]
                        lg:self-start
                    "
                >
                    @if ($heading !== '')
                        <h2
                            class="
                                text-[2rem]
                                font-bold
                                leading-tight
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
                                max-w-lg
                                text-[0.9375rem]
                                leading-[1.7]
                                text-rino-muted
                                sm:text-[1rem]
                            "
                        >
                            {{ $description }}
                        </p>
                    @endif

                    @if (
                        $ctaEnabled
                        &&
                        $ctaLabel !== ''
                        &&
                        $ctaUrl !== ''
                    )
                        <div class="mt-7">
                            <x-ui.button
                                :href="$ctaUrl"
                                :variant="$ctaStyle"
                            >
                                {{ $ctaLabel }}

                                @if (
                                    $ctaStyle === 'icon-circle'
                                    &&
                                    $ctaIcon !== 'none'
                                )
                                    <x-slot:icon>
                                        @include(
                                            'components.sections.partials.button-icon',
                                            [
                                                'icon' => $ctaIcon,
                                            ]
                                        )
                                    </x-slot:icon>
                                @endif
                            </x-ui.button>
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach ($questions as $item)
                        <details
                            class="
                                group
                                overflow-hidden
                                rounded-[var(--radius-card)]
                                bg-rino-surface
                                ring-1
                                ring-inset
                                ring-black/5
                            "
                        >
                            <summary
                                class="
                                    flex
                                    cursor-pointer
                                    list-none
                                    items-center
                                    justify-between
                                    gap-5
                                    px-5
                                    py-5
                                    text-left
                                    sm:px-6
                                    sm:py-6
                                "
                            >
                                <span
                                    class="
                                        text-[0.9375rem]
                                        font-semibold
                                        leading-snug
                                        text-rino-heading
                                        sm:text-[1rem]
                                    "
                                >
                                    {{ $item['question'] }}
                                </span>

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="
                                        h-5
                                        w-5
                                        shrink-0
                                        text-rino-muted
                                        transition-transform
                                        duration-200
                                        group-open:rotate-180
                                    "
                                    aria-hidden="true"
                                >
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </summary>

                            <div
                                class="
                                    px-5
                                    pb-5
                                    text-[0.9375rem]
                                    leading-[1.75]
                                    text-rino-muted
                                    sm:px-6
                                    sm:pb-6
                                "
                            >
                                {{ $item['answer'] }}
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        @else
            @if ($heading !== '' || $description !== '')
                <div
                    class="
                        mb-10
                        max-w-3xl
                        sm:mb-12
                        {{ $centered
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
                                leading-tight
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

            <div
                class="
                    w-full
                    max-w-6xl
                    space-y-4
                    {{ $centered
                        ? 'mx-auto'
                        : ''
                    }}
                "
            >
                @foreach ($questions as $item)
                    <details
                        class="
                            group
                            overflow-hidden
                            rounded-[var(--radius-card)]
                            bg-rino-surface
                            ring-1
                            ring-inset
                            ring-black/5
                        "
                    >
                        <summary
                            class="
                                flex
                                cursor-pointer
                                list-none
                                items-center
                                justify-between
                                gap-5
                                px-5
                                py-5
                                text-left
                                sm:px-6
                                sm:py-6
                            "
                        >
                            <span
                                class="
                                    text-[0.9375rem]
                                    font-semibold
                                    leading-snug
                                    text-rino-heading
                                    sm:text-[1rem]
                                "
                            >
                                {{ $item['question'] }}
                            </span>

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="
                                    h-5
                                    w-5
                                    shrink-0
                                    text-rino-muted
                                    transition-transform
                                    duration-200
                                    group-open:rotate-180
                                "
                                aria-hidden="true"
                            >
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </summary>

                        <div
                            class="
                                px-5
                                pb-5
                                text-[0.9375rem]
                                leading-[1.75]
                                text-rino-muted
                                sm:px-6
                                sm:pb-6
                            "
                        >
                            {{ $item['answer'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        @endif
    </div>
</section>