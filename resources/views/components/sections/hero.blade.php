@php
    use Illuminate\Support\Facades\Storage;

    $enabled =
        $section['enabled'] ?? true;

    if (!$enabled) {
        return;
    }

    $alignment =
        $section['alignment'] ?? 'left';

    $topElement =
        $section['top_element'] ?? 'none';

    $tagText =
        $section['tag_text'] ?? null;

    $socialProofAvatars =
        is_array(
            $section['social_proof_avatars'] ?? null
        )
            ? $section['social_proof_avatars']
            : [];

    $socialProofTitle =
        $section['social_proof_title'] ?? null;

    $socialProofSubtitle =
        $section['social_proof_subtitle'] ?? null;

    $heading =
        $section['heading'] ?? '';

    $highlightedText =
        $section['highlighted_text'] ?? '';

    $description =
        $section['description'] ?? null;

    $primaryButtonEnabled =
        (bool) (
            $section['primary_button_enabled']
            ?? false
        );

    $primaryButtonLabel =
        $section['primary_button_label'] ?? null;

    $primaryButtonUrl =
        $section['primary_button_url'] ?? null;

    $primaryButtonStyle =
        $section['primary_button_style']
        ?? 'normal';

    $primaryButtonIcon =
        $section['primary_button_icon']
        ?? 'none';

    $secondaryButtonEnabled =
        (bool) (
            $section['secondary_button_enabled']
            ?? false
        );

    $secondaryButtonLabel =
        $section['secondary_button_label'] ?? null;

    $secondaryButtonUrl =
        $section['secondary_button_url'] ?? null;

    $secondaryButtonStyle =
        $section['secondary_button_style']
        ?? 'normal';

    $secondaryButtonIcon =
        $section['secondary_button_icon']
        ?? 'none';

    $backgroundImage =
        $section['background_image'] ?? null;

    $backgroundPosition =
        $section['background_position']
        ?? 'center';

    $backgroundUrl =
    \App\Support\AssetUrl::resolve(
        $backgroundImage
    );

    $backgroundSettings =
        match ($backgroundPosition) {
            'top' => [
                'position' => '50% 0%',
                'scale' => '1.18',
                'origin' => 'center top',
            ],

            'right' => [
                'position' => '100% 50%',
                'scale' => '1.18',
                'origin' => 'right center',
            ],

            default => [
                'position' => '50% 50%',
                'scale' => '1.03',
                'origin' => 'center center',
            ],
        };

    $isCentered =
        $alignment === 'center';

    $highlightStart = null;

    if (
        filled($heading) &&
        filled($highlightedText)
    ) {
        $highlightStart =
            mb_stripos(
                $heading,
                $highlightedText
            );
    }

    $headingBefore =
        $heading;

    $headingHighlight =
        null;

    $headingAfter =
        null;

    if (
        $highlightStart !== false &&
        $highlightStart !== null
    ) {
        $headingBefore =
            mb_substr(
                $heading,
                0,
                $highlightStart
            );

        $headingHighlight =
            mb_substr(
                $heading,
                $highlightStart,
                mb_strlen($highlightedText)
            );

        $headingAfter =
            mb_substr(
                $heading,
                $highlightStart +
                    mb_strlen($highlightedText)
            );
    }
@endphp

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

    @if ($backgroundUrl)

        <div
            class="
                absolute
                inset-0
                -z-30
                overflow-hidden
            "
        >
            <img
                src="{{ $backgroundUrl }}"
                alt=""
                draggable="false"
                class="
                    h-full
                    w-full
                    select-none
                    object-cover
                    pointer-events-none
                "
                style="
                    object-position:
                        {{ $backgroundSettings['position'] }};

                    transform:
                        scale(
                            {{ $backgroundSettings['scale'] }}
                        );

                    transform-origin:
                        {{ $backgroundSettings['origin'] }};

                    transition:
                        object-position 300ms ease,
                        transform 300ms ease;
                "
            >
        </div>


        <div
            class="
                absolute
                inset-0
                -z-20
                pointer-events-none
            "
            style="
                background:
                    radial-gradient(
                        ellipse 105% 95% at 4% 36%,
                        color-mix(
                            in srgb,
                            var(--background) 44%,
                            transparent
                        ) 0%,
                        color-mix(
                            in srgb,
                            var(--background) 22%,
                            transparent
                        ) 36%,
                        transparent 70%
                    ),
                    linear-gradient(
                        to bottom,
                        color-mix(
                            in srgb,
                            var(--background) 18%,
                            transparent
                        ) 0%,
                        color-mix(
                            in srgb,
                            var(--background) 24%,
                            transparent
                        ) 20%,
                        color-mix(
                            in srgb,
                            var(--background) 38%,
                            transparent
                        ) 44%,
                        color-mix(
                            in srgb,
                            var(--background) 62%,
                            transparent
                        ) 66%,
                        color-mix(
                            in srgb,
                            var(--background) 86%,
                            transparent
                        ) 84%,
                        var(--background) 100%
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
            py-8
            sm:min-h-[395px]
            sm:px-6
            sm:py-10
            lg:min-h-[425px]
            lg:px-8
            lg:py-12
        "
    >

        <div
            class="
                w-full
                max-w-3xl
                -translate-y-2
                sm:-translate-y-3
                {{ $isCentered
                    ? 'mx-auto text-center'
                    : 'text-left'
                }}
            "
        >

            @if (
                $topElement === 'tag' &&
                filled($tagText)
            )

                <div
                    class="
                        mb-4
                        flex
                        {{ $isCentered
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
                        {{ $tagText }}
                    </span>
                </div>


            @elseif (
                $topElement === 'social_proof'
            )

                <div
                    class="
                        mb-5
                        flex
                        items-center
                        gap-4
                        {{ $isCentered
                            ? 'justify-center'
                            : 'justify-start'
                        }}
                    "
                >

                    @if (count($socialProofAvatars))

                        <div
                            class="
                                flex
                                shrink-0
                                -space-x-2
                            "
                        >

                            @foreach (
                                array_slice(
                                    $socialProofAvatars,
                                    0,
                                    4
                                )
                                as $avatar
                            )

                                @php
                                    $avatarPath =
                                        $avatar['image']
                                        ?? null;

                                    $avatarUrl =
                                        $avatarPath
                                            ? (
                                                str_starts_with(
                                                    ltrim(
                                                        $avatarPath,
                                                        '/'
                                                    ),
                                                    'assets/'
                                                )
                                                    ? asset(
                                                        ltrim(
                                                            $avatarPath,
                                                            '/'
                                                        )
                                                    )
                                                    : Storage::disk(
                                                        'public'
                                                    )->url(
                                                        $avatarPath
                                                    )
                                            )
                                            : null;
                                @endphp

                                @if ($avatarUrl)

                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt=""
                                        class="
                                            relative
                                            h-9
                                            w-9
                                            rounded-full
                                            border-2
                                            border-rino-background
                                            object-cover
                                        "
                                        style="
                                            box-shadow:
                                                0 0 0 1px
                                                var(--border);
                                        "
                                    >

                                @endif

                            @endforeach

                        </div>

                    @endif


                    @if (
                        filled($socialProofTitle) ||
                        filled($socialProofSubtitle)
                    )

                        <div
                            class="
                                min-w-0
                                text-left
                            "
                        >

                            @if (filled($socialProofTitle))

                                <div
                                    class="
                                        flex
                                        items-center
                                        gap-2
                                        text-sm
                                        font-semibold
                                        text-rino-heading
                                    "
                                >

                                    <svg
                                        class="
                                            h-5
                                            w-5
                                            shrink-0
                                            text-rino-primary
                                        "
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M12 2.75 14.86 8.55 21.26 9.48 16.63 13.99 17.72 20.36 12 17.35 6.28 20.36 7.37 13.99 2.74 9.48 9.14 8.55 12 2.75Z"
                                        />
                                    </svg>

                                    <span>
                                        {{ $socialProofTitle }}
                                    </span>

                                </div>

                            @endif


                            @if (filled($socialProofSubtitle))

                                <div
                                    class="
                                        mt-0.5
                                        text-sm
                                        text-rino-body
                                    "
                                >
                                    {{ $socialProofSubtitle }}
                                </div>

                            @endif

                        </div>

                    @endif

                </div>

            @endif


            @if (filled($heading))

                <h1
                    class="
                        max-w-4xl
                        text-3xl
                        font-bold
                        leading-[1.08]
                        tracking-tight
                        text-rino-heading
                        sm:text-4xl
                        md:text-5xl
                        lg:text-[3.35rem]
                        {{ $isCentered
                            ? 'mx-auto'
                            : ''
                        }}
                    "
                >

                    @if ($headingHighlight !== null)

                        {{ $headingBefore }}<span
                            class="text-rino-primary"
                        >{{ $headingHighlight }}</span>{{ $headingAfter }}

                    @else

                        {{ $heading }}

                    @endif

                </h1>

            @endif


            @if (filled($description))

                <p
                    class="
                        mt-4
                        max-w-2xl
                        text-[15px]
                        leading-7
                        text-rino-muted
                        sm:text-base
                        lg:text-lg
                        {{ $isCentered
                            ? 'mx-auto'
                            : ''
                        }}
                    "
                >
                    {{ $description }}
                </p>

            @endif


            @if (
                (
                    $primaryButtonEnabled &&
                    filled($primaryButtonLabel) &&
                    filled($primaryButtonUrl)
                )
                ||
                (
                    $secondaryButtonEnabled &&
                    filled($secondaryButtonLabel) &&
                    filled($secondaryButtonUrl)
                )
            )

                <div
                    class="
                        mt-6
                        flex
                        flex-wrap
                        items-center
                        gap-3
                        {{ $isCentered
                            ? 'justify-center'
                            : 'justify-start'
                        }}
                    "
                >

                    @if (
                        $primaryButtonEnabled &&
                        filled($primaryButtonLabel) &&
                        filled($primaryButtonUrl)
                    )

                        <x-ui.button
                            :href="$primaryButtonUrl"
                            :variant="$primaryButtonStyle"
                        >
                            {{ $primaryButtonLabel }}

                            @if (
                                $primaryButtonStyle ===
                                    'icon-circle'
                                &&
                                $primaryButtonIcon !==
                                    'none'
                            )

                                <x-slot:icon>

                                    @include(
                                        'components.sections.partials.button-icon',
                                        [
                                            'icon' =>
                                                $primaryButtonIcon,
                                        ]
                                    )

                                </x-slot:icon>

                            @endif

                        </x-ui.button>

                    @endif


                    @if (
                        $secondaryButtonEnabled &&
                        filled($secondaryButtonLabel) &&
                        filled($secondaryButtonUrl)
                    )

                        <x-ui.button
                            :href="$secondaryButtonUrl"
                            :variant="$secondaryButtonStyle"
                            style="
                                background:
                                    color-mix(
                                        in srgb,
                                        var(--surface) 78%,
                                        transparent
                                    );

                                color:
                                    var(--text-heading);

                                border:
                                    1.5px solid
                                    color-mix(
                                        in srgb,
                                        var(--text-heading) 24%,
                                        transparent
                                    );

                                border-radius:
                                    var(--radius-button);

                                backdrop-filter:
                                    blur(8px);

                                -webkit-backdrop-filter:
                                    blur(8px);
                            "
                        >
                            {{ $secondaryButtonLabel }}

                            @if (
                                $secondaryButtonStyle ===
                                    'icon-circle'
                                &&
                                $secondaryButtonIcon !==
                                    'none'
                            )

                                <x-slot:icon>

                                    @include(
                                        'components.sections.partials.button-icon',
                                        [
                                            'icon' =>
                                                $secondaryButtonIcon,
                                        ]
                                    )

                                </x-slot:icon>

                            @endif

                        </x-ui.button>

                    @endif

                </div>

            @endif

        </div>

    </div>

</section>