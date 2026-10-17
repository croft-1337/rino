@props([
    'name' => 'check',
])

@switch($name)

    @case('memory')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="3" y="7" width="18" height="10" rx="2"/>
            <path d="M7 10v4M10 10v4M13 10v4M16 10v4"/>
            <path d="M6 17v3M10 17v3M14 17v3M18 17v3"/>
        </svg>
        @break

    @case('cpu')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="7" y="7" width="10" height="10" rx="2"/>
            <rect x="10" y="10" width="4" height="4" rx="1"/>
            <path d="M9 3v4M15 3v4M9 17v4M15 17v4M3 9h4M3 15h4M17 9h4M17 15h4"/>
        </svg>
        @break

    @case('storage')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M5 7h14l2 5H3l2-5Z"/>
            <rect x="3" y="12" width="18" height="6" rx="2"/>
            <path d="M17 15h.01M14 15h.01"/>
        </svg>
        @break

    @case('database')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <ellipse cx="12" cy="5" rx="7" ry="3"/>
            <path d="M5 5v6c0 1.7 3.1 3 7 3s7-1.3 7-3V5"/>
            <path d="M5 11v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>
        </svg>
        @break

    @case('server')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="3" y="4" width="18" height="6" rx="2"/>
            <rect x="3" y="14" width="18" height="6" rx="2"/>
            <path d="M7 7h.01M7 17h.01M11 7h6M11 17h6"/>
        </svg>
        @break

    @case('users')
    @case('players')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="9" cy="8" r="3"/>
            <circle cx="17" cy="9" r="2.5"/>
            <path d="M3 19c.6-3.3 2.7-5 6-5s5.4 1.7 6 5"/>
            <path d="M14 14.5c1-.7 2-.9 3.2-.9 2.4 0 4 1.3 4.8 3.9"/>
        </svg>
        @break

    @case('support')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M4 13v-2a8 8 0 0 1 16 0v2"/>
            <path d="M4 13h3v6H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 1-2Z"/>
            <path d="M20 13h-3v6h2c1.1 0 2-.9 2-2v-2c0-.9-.4-1.6-1-2Z"/>
            <path d="M17 19c-.7 1.3-2.1 2-4 2"/>
        </svg>
        @break

    @case('shield')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M12 3 20 6v5c0 5-3 8.5-8 10-5-1.5-8-5-8-10V6l8-3Z"/>
            <path d="m9 12 2 2 4-5"/>
        </svg>
        @break

    @case('network')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="9" y="3" width="6" height="5" rx="1"/>
            <rect x="3" y="16" width="6" height="5" rx="1"/>
            <rect x="15" y="16" width="6" height="5" rx="1"/>
            <path d="M12 8v4M6 16v-4h12v4"/>
        </svg>
        @break

    @case('bandwidth')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M4 15a8 8 0 1 1 16 0"/>
            <path d="m12 15 4-5"/>
            <circle cx="12" cy="15" r="1.5"/>
            <path d="M6.5 18h11"/>
        </svg>
        @break

    @case('backup')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M4 12a8 8 0 1 0 2.3-5.7"/>
            <path d="M4 4v6h6"/>
            <path d="M12 8v5l3 2"/>
        </svg>
        @break

    @case('clock')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="9"/>
            <path d="M12 7v5l3 2"/>
        </svg>
        @break

    @case('globe')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="9"/>
            <path d="M3 12h18M12 3c2.5 2.5 3.5 5.5 3.5 9S14.5 18.5 12 21M12 3c-2.5 2.5-3.5 5.5-3.5 9s1 6.5 3.5 9"/>
        </svg>
        @break

    @case('cloud')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M7 18h10a4 4 0 0 0 .8-7.9A6 6 0 0 0 6.4 8.5 4.8 4.8 0 0 0 7 18Z"/>
        </svg>
        @break

    @case('bolt')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M13 2 5 14h6l-1 8 9-13h-6V2Z"/>
        </svg>
        @break

    @case('rocket')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M14 5c2.8-1.7 5.5-1.5 6-1-.1 3-1.1 6.2-4 9l-4 4-5-5 4-4 3-3Z"/>
            <path d="M9 10 5 9 2 12l5 2M14 15l1 4-3 3-2-5"/>
            <circle cx="15.5" cy="8.5" r="1.5"/>
        </svg>
        @break

    @case('gamepad')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M7 8h10c2.5 0 4 2 4 4.5 0 4.2-1.5 6.5-3.5 6.5-1.3 0-2.2-1-3.1-2H9.6c-.9 1-1.8 2-3.1 2C4.5 19 3 16.7 3 12.5 3 10 4.5 8 7 8Z"/>
            <path d="M8 11v4M6 13h4M16 12h.01M18 14h.01"/>
        </svg>
        @break

    @case('terminal')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="3" y="4" width="18" height="16" rx="2"/>
            <path d="m7 9 3 3-3 3M13 15h4"/>
        </svg>
        @break

    @case('desktop')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="3" y="4" width="18" height="13" rx="2"/>
            <path d="M8 21h8M12 17v4"/>
        </svg>
        @break

    @case('linux')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M9 8c0-3 1-5 3-5s3 2 3 5"/>
            <path d="M8 10c-2 2-3 5-2 8h12c1-3 0-6-2-8"/>
            <path d="M9 18c-1 1-2 2-3 2M15 18c1 1 2 2 3 2"/>
            <path d="M10 9h.01M14 9h.01M11 12h2"/>
        </svg>
        @break

    @case('windows')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="currentColor"
        >
            <path d="M3 5.2 10.4 4v7.2H3V5.2Zm8.5-1.4L21 2.4v8.8h-9.5V3.8ZM3 12.3h7.4v7.3L3 18.4v-6.1Zm8.5 0H21v8.9l-9.5-1.4v-7.5Z"/>
        </svg>
        @break

    @case('code')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 5l-4 14"/>
        </svg>
        @break

    @case('lock')
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="5" y="10" width="14" height="10" rx="2"/>
            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
        </svg>
        @break

    @default
        <svg
            {{ $attributes }}
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="m5 12 4 4L19 6"/>
        </svg>

@endswitch