@props([
    'type' => 'none',
    'asset' => null,
    'icon' => null,
    'image' => null,
])

@php
    use Illuminate\Support\Facades\Storage;

    $flagMap = [
        'flag-us' => '🇺🇸',
        'flag-gb' => '🇬🇧',
        'flag-de' => '🇩🇪',
        'flag-fr' => '🇫🇷',
        'flag-nl' => '🇳🇱',
        'flag-sg' => '🇸🇬',
        'flag-au' => '🇦🇺',
        'flag-ca' => '🇨🇦',
        'flag-jp' => '🇯🇵',
        'flag-pk' => '🇵🇰',
    ];

    $assetTextMap = [
        'game-minecraft' => 'MC',
        'game-hytale' => 'HY',
        'game-ark' => 'ARK',
        'game-cs2' => 'CS2',
        'game-rust' => 'RUST',
        'game-fivem' => '5M',

        'hardware-amd' => 'AMD',
        'hardware-intel' => 'INTEL',

        'hosting-game' => 'GAME',
        'hosting-vps' => 'VPS',
        'hosting-web' => 'WEB',
        'hosting-bot' => 'BOT',
        'hosting-dedicated' => 'DS',
    ];

    $imageUrl =
        $image
            ? Storage::disk('public')->url($image)
            : null;
@endphp


@if ($type === 'upload' && $imageUrl)

    <img
        src="{{ $imageUrl }}"
        alt=""
        class="
            h-full
            w-full
            object-contain
        "
    >

@elseif (
    $type === 'built_in' &&
    isset($flagMap[$asset])
)

    <span
        class="
            text-xl
            leading-none
        "
    >
        {{ $flagMap[$asset] }}
    </span>

@elseif (
    $type === 'built_in' &&
    isset($assetTextMap[$asset])
)

    <span
        class="
            text-[10px]
            font-bold
            tracking-tight
            text-rino-primary
        "
    >
        {{ $assetTextMap[$asset] }}
    </span>

@elseif ($type === 'icon')

    @switch($icon)

        @case('gamepad')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
                aria-hidden="true"
            >
                <path
                    d="M8.5 8H15.5C18.5 8 20 10.4 20 13.3C20 16.4 18.7 19 16.7 19C15.2 19 14.4 17.6 13.6 16.5H10.4C9.6 17.6 8.8 19 7.3 19C5.3 19 4 16.4 4 13.3C4 10.4 5.5 8 8.5 8Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M8 11V15M6 13H10"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

            @break


        @case('globe')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <circle
                    cx="12"
                    cy="12"
                    r="8"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M4 12H20M12 4C14 6.2 15 8.9 15 12C15 15.1 14 17.8 12 20M12 4C10 6.2 9 8.9 9 12C9 15.1 10 17.8 12 20"
                    stroke="currentColor"
                    stroke-width="1.6"
                />
            </svg>

            @break


        @case('location')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <path
                    d="M12 21S18 15.8 18 10A6 6 0 0 0 6 10C6 15.8 12 21 12 21Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <circle
                    cx="12"
                    cy="10"
                    r="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @case('cpu')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <rect
                    x="7"
                    y="7"
                    width="10"
                    height="10"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M9 2V5M15 2V5M9 19V22M15 19V22M2 9H5M2 15H5M19 9H22M19 15H22"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

            @break


        @case('memory')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <rect
                    x="3"
                    y="7"
                    width="18"
                    height="10"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M7 10V14M11 10V14M15 10V14M19 10V14"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @case('storage')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <ellipse
                    cx="12"
                    cy="6"
                    rx="7"
                    ry="3"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M5 6V12C5 13.7 8.1 15 12 15C15.9 15 19 13.7 19 12V6M5 12V18C5 19.7 8.1 21 12 21C15.9 21 19 19.7 19 18V12"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @case('shield')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <path
                    d="M12 3L19 6V11C19 15.5 16.2 19 12 21C7.8 19 5 15.5 5 11V6L12 3Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @case('rocket')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <path
                    d="M14 5C16 3 18.5 3 20 3C20 4.5 20 7 18 9L13 14L10 11L14 5Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M10 11L6 12L4 15L9 15M13 14L12 18L9 20L9 15"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @case('terminal')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <path
                    d="M5 7L10 12L5 17M12 17H19"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            @break


        @case('code')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <path
                    d="M8 7L3 12L8 17M16 7L21 12L16 17M14 4L10 20"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            @break


        @case('desktop')

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <rect
                    x="3"
                    y="4"
                    width="18"
                    height="13"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M8 21H16M12 17V21"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

            @break


        @default

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="h-5 w-5"
            >
                <rect
                    x="4"
                    y="5"
                    width="16"
                    height="6"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <rect
                    x="4"
                    y="13"
                    width="16"
                    height="6"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>

    @endswitch

@endif