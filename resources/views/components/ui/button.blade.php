@props([
    'variant' => 'normal',
    'href' => null,
    'type' => 'button',
    'target' => null,
])

@php
    $baseClasses = '
        inline-flex
        shrink-0
        items-center
        justify-center
        whitespace-nowrap
        bg-rino-primary
        font-semibold
        text-rino-primary-text
        transition-opacity
        duration-200
        hover:opacity-90
        focus:outline-none
    ';

    $variantClasses = match ($variant) {
        'icon-circle' => '
            h-10
            gap-3
            pl-4
            pr-1.5
            text-sm
        ',

        default => '
            h-10
            px-4
            text-sm
        ',
    };
@endphp

@if ($href)

    <a
        href="{{ $href }}"

        @if ($target)
            target="{{ $target }}"
        @endif

        @if ($target === '_blank')
            rel="noopener noreferrer"
        @endif

        {{ $attributes
            ->class([
                $baseClasses,
                $variantClasses,
            ])
            ->merge([
                'style' => 'border-radius: var(--radius-button);',
            ])
        }}
    >
        <span>
            {{ $slot }}
        </span>

        @if (
            $variant === 'icon-circle'
            &&
            isset($icon)
        )
            <span
                class="
                    flex
                    h-7
                    w-7
                    shrink-0
                    items-center
                    justify-center
                    rounded-full
                    bg-rino-heading
                    text-rino-background
                "
            >
                {{ $icon }}
            </span>
        @endif
    </a>

@else

    <button
        type="{{ $type }}"

        {{ $attributes
            ->class([
                $baseClasses,
                $variantClasses,
            ])
            ->merge([
                'style' => 'border-radius: var(--radius-button);',
            ])
        }}
    >
        <span>
            {{ $slot }}
        </span>

        @if (
            $variant === 'icon-circle'
            &&
            isset($icon)
        )
            <span
                class="
                    flex
                    h-7
                    w-7
                    shrink-0
                    items-center
                    justify-center
                    rounded-full
                    bg-rino-heading
                    text-rino-background
                "
            >
                {{ $icon }}
            </span>
        @endif
    </button>

@endif