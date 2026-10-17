@props([
    'platform',
])

@switch($platform)

    @case('discord')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M19.54 5.34A17.2 17.2 0 0 0 15.38 4l-.52 1.06a15.5 15.5 0 0 0-5.72 0L8.62 4a17.2 17.2 0 0 0-4.16 1.34C1.83 9.28 1.12 13.12 1.48 16.9a16.8 16.8 0 0 0 5.1 2.58l1.23-1.68a10.6 10.6 0 0 1-1.93-.92l.47-.36c3.73 1.72 7.77 1.72 11.46 0l.48.36c-.61.36-1.26.67-1.93.92l1.23 1.68a16.8 16.8 0 0 0 5.1-2.58c.43-4.38-.73-8.18-2.65-11.56ZM8.52 14.6c-1.12 0-2.04-1.03-2.04-2.3 0-1.27.9-2.3 2.04-2.3s2.06 1.04 2.04 2.3c0 1.27-.9 2.3-2.04 2.3Zm6.96 0c-1.12 0-2.04-1.03-2.04-2.3 0-1.27.9-2.3 2.04-2.3s2.06 1.04 2.04 2.3c0 1.27-.9 2.3-2.04 2.3Z" />
        </svg>
        @break

    @case('x')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M18.9 2H22l-6.77 7.74L23.2 22h-6.24l-4.89-6.39L6.48 22H3.36l7.26-8.3L2.97 2h6.4l4.42 5.84L18.9 2Zm-1.1 18h1.73L8.43 3.9H6.58L17.8 20Z" />
        </svg>
        @break

    @case('github')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M12 2C6.48 2 2 6.58 2 12.23c0 4.52 2.87 8.36 6.84 9.71.5.1.68-.22.68-.49v-1.92c-2.78.62-3.37-1.21-3.37-1.21-.45-1.18-1.11-1.5-1.11-1.5-.91-.64.07-.62.07-.62 1 .07 1.53 1.06 1.53 1.06.9 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.64-1.36-2.22-.26-4.56-1.14-4.56-5.06 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.31.1-2.72 0 0 .84-.28 2.75 1.05A9.4 9.4 0 0 1 12 6.92a9.4 9.4 0 0 1 2.5.35c1.91-1.33 2.75-1.05 2.75-1.05.55 1.41.2 2.46.1 2.72.64.72 1.03 1.63 1.03 2.75 0 3.93-2.35 4.8-4.58 5.05.36.32.68.94.68 1.9v2.81c0 .27.18.59.69.49A10.2 10.2 0 0 0 22 12.23C22 6.58 17.52 2 12 2Z" />
        </svg>
        @break

    @case('youtube')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M23.5 6.2a3 3 0 0 0-2.1-2.12C19.54 3.58 12 3.58 12 3.58s-7.54 0-9.4.5A3 3 0 0 0 .5 6.2 31.7 31.7 0 0 0 0 12a31.7 31.7 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.12c1.86.5 9.4.5 9.4.5s7.54 0 9.4-.5a3 3 0 0 0 2.1-2.12A31.7 31.7 0 0 0 24 12a31.7 31.7 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.27 3.6L9.6 15.6Z" />
        </svg>
        @break

    @case('facebook')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M13.5 8H16l.4-3h-2.9C10.95 5 9 6.95 9 9.5V12H6v3h3v7h4v-7h3l.5-3h-3.5V9.75c0-1.04.46-1.75 1.5-1.75Z" />
        </svg>
        @break

    @case('instagram')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            aria-hidden="true"
        >
            <rect x="3" y="3" width="18" height="18" rx="5" />
            <circle cx="12" cy="12" r="4" />
            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
        </svg>
        @break

    @case('linkedin')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M6.5 8.5H3.2V21h3.3V8.5ZM4.85 3A1.85 1.85 0 1 0 4.85 6.7 1.85 1.85 0 0 0 4.85 3ZM21 13.9c0-3.77-2.01-5.53-4.7-5.53-2.17 0-3.14 1.2-3.68 2.04V8.5H9.3c.04 1.27 0 12.5 0 12.5h3.32v-6.98c0-.37.03-.75.14-1.02.3-.75.98-1.53 2.12-1.53 1.5 0 2.1 1.14 2.1 2.82V21H21v-7.1Z" />
        </svg>
        @break

    @default
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            aria-hidden="true"
        >
            <circle cx="12" cy="12" r="9" />
            <path d="M3 12h18" />
            <path d="M12 3a15 15 0 0 1 0 18" />
            <path d="M12 3a15 15 0 0 0 0 18" />
        </svg>

@endswitch