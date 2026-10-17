@php
    $enabled =
        $section['enabled']
        ?? true;

    if (!$enabled) {
        return;
    }

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

    $primaryButtonEnabled =
        (bool) (
            $section['primary_button_enabled']
            ?? true
        );

    $primaryButtonLabel =
        trim(
            (string) (
                $section['primary_button_label']
                ?? ''
            )
        );

    $primaryButtonUrl =
        trim(
            (string) (
                $section['primary_button_url']
                ?? ''
            )
        );

    $primaryButtonStyle =
        $section['primary_button_style']
        ?? 'icon-circle';

    $primaryButtonIcon =
        $section['primary_button_icon']
        ?? 'arrow-right';

    $secondaryButtonEnabled =
        (bool) (
            $section['secondary_button_enabled']
            ?? false
        );

    $secondaryButtonLabel =
        trim(
            (string) (
                $section['secondary_button_label']
                ?? ''
            )
        );

    $secondaryButtonUrl =
        trim(
            (string) (
                $section['secondary_button_url']
                ?? ''
            )
        );

    $secondaryButtonStyle =
        $section['secondary_button_style']
        ?? 'normal';

    $secondaryButtonIcon =
        $section['secondary_button_icon']
        ?? 'arrow-right';

    $hasPrimaryButton =
        $primaryButtonEnabled
        &&
        $primaryButtonLabel !== ''
        &&
        $primaryButtonUrl !== '';

    $hasSecondaryButton =
        $secondaryButtonEnabled
        &&
        $secondaryButtonLabel !== ''
        &&
        $secondaryButtonUrl !== '';

    $hasButtons =
        $hasPrimaryButton
        ||
        $hasSecondaryButton;
@endphp

<section
    class="
        bg-rino-background
        px-4
        py-12
        sm:px-6
        sm:py-14
        lg:px-8
        lg:py-16
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
                relative
                overflow-hidden
                rounded-[var(--radius-card)]
                bg-rino-surface
                px-5
                py-8
                ring-1
                ring-inset
                ring-black/5
                sm:px-7
                sm:py-9
                lg:px-8
                lg:py-10
            "
        >
            @if ($layout === 'split')
                <div
                    class="
                        relative
                        z-10
                        grid
                        grid-cols-1
                        items-center
                        gap-7
                        lg:grid-cols-[minmax(0,1fr)_auto]
                        lg:gap-10
                    "
                >
                    <div
                        class="
                            min-w-0
                            max-w-3xl
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
                                "
                            >
                                {{ $description }}
                            </p>
                        @endif
                    </div>

                    @if ($hasButtons)
                        <div
                            class="
                                flex
                                flex-wrap
                                items-center
                                gap-3
                                lg:justify-end
                            "
                        >
                            @if ($hasPrimaryButton)
                                <x-ui.button
                                    :href="$primaryButtonUrl"
                                    :variant="$primaryButtonStyle"
                                    class="
                                        min-h-12
                                        px-5
                                        text-[1rem]
                                        font-semibold
                                    "
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

                            @if ($hasSecondaryButton)
                                <x-ui.button
                                    :href="$secondaryButtonUrl"
                                    :variant="$secondaryButtonStyle"
                                    class="
                                        min-h-12
                                        px-5
                                        text-[1rem]
                                        font-semibold
                                    "
                                    style="
                                        background:
                                            color-mix(
                                                in srgb,
                                                var(--surface-secondary) 84%,
                                                transparent
                                            );

                                        color:
                                            var(--text-heading);
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
            @else
                <div
                    class="
                        relative
                        z-10
                        mx-auto
                        max-w-3xl
                        text-center
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
                                mx-auto
                                mt-4
                                max-w-2xl
                                text-[0.9375rem]
                                leading-[1.7]
                                text-rino-muted
                                sm:text-[1rem]
                            "
                        >
                            {{ $description }}
                        </p>
                    @endif

                    @if ($hasButtons)
                        <div
                            class="
                                mt-7
                                flex
                                flex-wrap
                                items-center
                                justify-center
                                gap-3
                            "
                        >
                            @if ($hasPrimaryButton)
                                <x-ui.button
                                    :href="$primaryButtonUrl"
                                    :variant="$primaryButtonStyle"
                                    class="
                                        min-h-12
                                        px-5
                                        text-[1rem]
                                        font-semibold
                                    "
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

                            @if ($hasSecondaryButton)
                                <x-ui.button
                                    :href="$secondaryButtonUrl"
                                    :variant="$secondaryButtonStyle"
                                    class="
                                        min-h-12
                                        px-5
                                        text-[1rem]
                                        font-semibold
                                    "
                                    style="
                                        background:
                                            color-mix(
                                                in srgb,
                                                var(--surface-secondary) 84%,
                                                transparent
                                            );

                                        color:
                                            var(--text-heading);
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
            @endif
        </div>
    </div>
</section>