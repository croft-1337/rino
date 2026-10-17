@props([
    'icon' => 'arrow-up-right',
])

@switch($icon)

    @case('arrow-right')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M5 12H19M14 7L19 12L14 17"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        @break


    @case('arrow-down')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M12 5V19M7 14L12 19L17 14"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        @break


    @case('chevron-right')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M9 6L15 12L9 18"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        @break


    @case('play')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M8 5.5L18 12L8 18.5V5.5Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
            />
        </svg>

        @break


    @case('server')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
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
            <path
                d="M8 8H8.01M8 16H8.01"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />
        </svg>

        @break


    @case('gamepad')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M8.5 8H15.5C18.5 8 20 10.4 20 13.3C20 16.4 18.7 19 16.7 19C15.2 19 14.4 17.6 13.6 16.5H10.4C9.6 17.6 8.8 19 7.3 19C5.3 19 4 16.4 4 13.3C4 10.4 5.5 8 8.5 8Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
            />
            <path
                d="M8 11V15M6 13H10"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
            />
            <circle
                cx="15"
                cy="12"
                r="1"
                fill="currentColor"
            />
            <circle
                cx="17"
                cy="14"
                r="1"
                fill="currentColor"
            />
        </svg>

        @break


    @case('rocket')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M14 5C16 3 18.5 3 20 3C20 4.5 20 7 18 9L13 14L10 11L14 5Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
            />
            <path
                d="M10 11L6 12L4 15L9 15L10 11Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
            />
            <path
                d="M13 14L12 18L9 20L9 15L13 14Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
            />
            <circle
                cx="16.5"
                cy="6.5"
                r="1.5"
                stroke="currentColor"
                stroke-width="1.5"
            />
        </svg>

        @break


    @case('globe')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
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
                stroke-linecap="round"
            />
        </svg>

        @break


    @case('external-link')

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M14 5H19V10M19 5L11 13"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M18 13V18C18 18.6 17.6 19 17 19H6C5.4 19 5 18.6 5 18V7C5 6.4 5.4 6 6 6H11"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
            />
        </svg>

        @break


    @default

        <svg
            viewBox="0 0 24 24"
            fill="none"
            class="h-4 w-4"
            aria-hidden="true"
        >
            <path
                d="M7 17L17 7M9 7H17V15"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

@endswitch