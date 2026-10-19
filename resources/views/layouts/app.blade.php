@php
    $defaultTheme =
        $theme['default_mode'] ?? 'dark';

    $allowThemeSwitch =
        $theme['allow_switch'] ?? true;

    $dark =
        $theme['dark'] ?? [];

    $light =
        $theme['light'] ?? [];

    $typography =
        $theme['typography'] ?? [];

    $radius =
        $theme['radius'] ?? [];

    $bodyFont =
        $typography['body_font']
        ?? 'system';

    $headingFont =
        $typography['heading_font']
        ?? 'system';

    $baseFontSize =
        $typography['base_font_size']
        ?? 16;

    $bodyFontFamily =
        \App\Support\Theme::fontFamily(
            $bodyFont
        );

    $headingFontFamily =
        \App\Support\Theme::fontFamily(
            $headingFont
        );

    $googleFontsUrl =
        \App\Support\Theme::googleFontsUrl(
            $bodyFont,
            $headingFont
        );
@endphp

<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-default-theme="{{ $defaultTheme }}"
    data-allow-theme-switch="{{ $allowThemeSwitch ? 'true' : 'false' }}"
>

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="color-scheme"
        content="dark light"
    >

    @php
        $seo = \App\Support\SeoData::resolve(
            get_defined_vars(),
            trim($__env->yieldContent('title', $siteName ?? 'Rino'))
        );
    @endphp

    <title>{{ $seo['title'] }}</title>

    @if ($seo['description'] !== '')
        <meta name="description" content="{{ $seo['description'] }}">
    @endif

    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    @if ($seo['company'] !== '')
        <meta name="author" content="{{ $seo['company'] }}">
    @endif

    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:site_name" content="{{ $seo['siteName'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    @if ($seo['description'] !== '')
        <meta property="og:description" content="{{ $seo['description'] }}">
    @endif
    @if ($seo['imageUrl'])
        <meta property="og:image" content="{{ $seo['imageUrl'] }}">
    @endif

    <meta name="twitter:card" content="{{ $seo['card'] }}">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    @if ($seo['description'] !== '')
        <meta name="twitter:description" content="{{ $seo['description'] }}">
    @endif
    @if ($seo['imageUrl'])
        <meta name="twitter:image" content="{{ $seo['imageUrl'] }}">
    @endif
    @if ($seo['twitter'])
        <meta name="twitter:site" content="{{ $seo['twitter'] }}">
    @endif


    @if (!empty($siteFavicon))

        <link
            rel="icon"
            href="{{ $siteFavicon }}"
        >

    @endif


    @if ($googleFontsUrl)

        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
        >

        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        >

        <link
            href="{{ $googleFontsUrl }}"
            rel="stylesheet"
        >

    @endif


    <script>
        (() => {
            const root =
                document.documentElement;

            const storageKey =
                'rino-theme';

            const defaultMode =
                root.dataset.defaultTheme ||
                'dark';

            const allowSwitch =
                root.dataset.allowThemeSwitch ===
                'true';

            let mode =
                defaultMode;

            if (allowSwitch) {
                const stored =
                    localStorage.getItem(
                        storageKey
                    );

                if (
                    stored === 'dark' ||
                    stored === 'light' ||
                    stored === 'system'
                ) {
                    mode = stored;
                }
            }

            const resolved =
                mode === 'system'
                    ? (
                        window.matchMedia(
                            '(prefers-color-scheme: dark)'
                        ).matches
                            ? 'dark'
                            : 'light'
                    )
                    : mode;

            root.dataset.theme =
                resolved;

            root.dataset.themeMode =
                mode;
        })();
    </script>


    <style>

        :root {

            --font-body:
                {!! $bodyFontFamily !!};

            --font-heading:
                {!! $headingFontFamily !!};

            --font-size-base:
                {{ $baseFontSize }}px;

            --radius-card:
                {{ $radius['card'] ?? 16 }}px;

            --radius-button:
                {{ $radius['button'] ?? 10 }}px;

            --radius-input:
                {{ $radius['input'] ?? 10 }}px;

            /*
             * Initial fallback values only.
             * JavaScript replaces these with exact
             * rendered pixel measurements immediately.
             */
            --rino-announcement-height:
                0px;

            --rino-header-height:
                64px;

            --rino-top-stack-height:
                64px;

        }


        html[data-theme="dark"] {

            --background:
                {{ $dark['background'] ?? '#09090b' }};

            --surface:
                {{ $dark['surface'] ?? '#18181b' }};

            --surface-secondary:
                {{ $dark['surface_secondary'] ?? '#27272a' }};

            --border:
                {{ $dark['border'] ?? '#3f3f46' }};

            --text-heading:
                {{ $dark['text_heading'] ?? '#ffffff' }};

            --text-body:
                {{ $dark['text_body'] ?? '#d4d4d8' }};

            --text-muted:
                {{ $dark['text_muted'] ?? '#a1a1aa' }};

            --primary:
                {{ $dark['primary'] ?? '#f59e0b' }};

            --primary-hover:
                {{ $dark['primary_hover'] ?? '#d97706' }};

            --primary-text:
                {{ $dark['primary_text'] ?? '#09090b' }};

        }


        html[data-theme="light"] {

            --background:
                {{ $light['background'] ?? '#ffffff' }};

            --surface:
                {{ $light['surface'] ?? '#fafafa' }};

            --surface-secondary:
                {{ $light['surface_secondary'] ?? '#f4f4f5' }};

            --border:
                {{ $light['border'] ?? '#d4d4d8' }};

            --text-heading:
                {{ $light['text_heading'] ?? '#18181b' }};

            --text-body:
                {{ $light['text_body'] ?? '#3f3f46' }};

            --text-muted:
                {{ $light['text_muted'] ?? '#71717a' }};

            --primary:
                {{ $light['primary'] ?? '#f59e0b' }};

            --primary-hover:
                {{ $light['primary_hover'] ?? '#d97706' }};

            --primary-text:
                {{ $light['primary_text'] ?? '#18181b' }};

        }


        html,
        body {
            margin: 0;
            padding: 0;
        }


        html {

            background:
                var(--background);

            color:
                var(--text-body);

            scroll-behavior:
                smooth;

        }


        body {

            min-height:
                100vh;

            overflow-x:
                hidden;

            background:
                var(--background);

            color:
                var(--text-body);

        }


        #rino-top-stack {
            pointer-events:
                none;
        }


        #rino-top-stack > * {
            pointer-events:
                auto;
        }


        #rino-header {

            position:
                relative;

            transition:
                background-color 250ms ease,
                box-shadow 250ms ease,
                backdrop-filter 250ms ease;

        }


        #rino-header[data-scrolled="false"] {

            background:
                transparent;

            box-shadow:
                none;

            backdrop-filter:
                none;

            -webkit-backdrop-filter:
                none;

        }


        #rino-header[data-scrolled="true"] {

            background:
                color-mix(
                    in srgb,
                    var(--surface) 94%,
                    transparent
                );

            box-shadow:
                0 1px 0
                color-mix(
                    in srgb,
                    var(--border) 70%,
                    transparent
                );

            backdrop-filter:
                blur(14px);

            -webkit-backdrop-filter:
                blur(14px);

        }


        [data-theme-option][data-active="true"] {

            background:
                var(--surface-secondary);

            color:
                var(--primary);

        }

    </style>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])


    @stack('head')

</head>


<body
    class="
        min-h-screen
        bg-rino-background
        text-rino-body
        antialiased
    "
>

    <div
        id="rino-top-stack"
        class="
            fixed
            inset-x-0
            top-0
            z-50
        "
    >

        @include(
            'components.announcement-bar'
        )

        @include(
            'components.header'
        )

    </div>


    <main
        id="rino-main"
        style="
            padding-top:
                var(--rino-top-stack-height);
        "
    >

        @yield('content')

    </main>


    @include(
        'components.footer'
    )


    @if ($cookieConsentEnabled ?? false)

        @php
            $cookieChoice =
                request()->cookie(
                    'rino_cookie_consent'
                );

            $cookieHasChoice =
                in_array(
                    $cookieChoice,
                    [
                        'analytics',
                        'essential',
                    ],
                    true
                );
        @endphp

        <div
            data-cookie-consent-root
            data-has-choice="{{ $cookieHasChoice ? 'true' : 'false' }}"
        >
            <button
                type="button"
                data-cookie-preferences-open
                aria-label="Cookie preferences"
                class="
                    fixed
                    bottom-5
                    right-5
                    z-[70]
                    flex
                    size-12
                    items-center
                    justify-center
                    rounded-full
                    bg-rino-primary
                    text-rino-primary-text
                    shadow-xl
                    transition
                    duration-200
                    hover:opacity-90
                    hidden
                "
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.9"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="size-6"
                    aria-hidden="true"
                >
                    <path d="M12 3a9 9 0 1 0 9 9c-1.8.2-3.3-.4-4.2-1.6-.9-1.2-1.1-2.8-.5-4.2C14.9 6.6 13.7 5.4 13 4c-.3-.4-.6-.8-1-1Z" />
                    <circle cx="8.5" cy="10" r=".8" fill="currentColor" stroke="none" />
                    <circle cx="11" cy="15" r=".8" fill="currentColor" stroke="none" />
                    <circle cx="7" cy="16" r=".8" fill="currentColor" stroke="none" />
                </svg>
            </button>

            <div
                data-cookie-consent-panel
                class="
                    fixed
                    bottom-4
                    right-4
                    z-[80]
                    w-[calc(100vw-2rem)]
                    max-w-[26rem]
                    rounded-[var(--radius-card)]
                    bg-rino-surface
                    p-5
                    shadow-2xl
                    sm:bottom-5
                    sm:right-5
                    sm:w-[26rem]
                    {{ $cookieHasChoice ? 'hidden' : '' }}
                "
                role="dialog"
                aria-modal="true"
                aria-labelledby="rino-cookie-title"
            >
                <button
                    type="button"
                    data-cookie-consent-close
                    aria-label="Close cookie preferences"
                    class="
                        absolute
                        right-4
                        top-4
                        flex
                        size-8
                        items-center
                        justify-center
                        rounded-full
                        text-rino-muted
                        transition-colors
                        hover:bg-rino-surface-secondary
                        hover:text-rino-heading
                    "
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        class="size-4"
                        aria-hidden="true"
                    >
                        <path d="M6 6l12 12" />
                        <path d="M18 6 6 18" />
                    </svg>
                </button>

                <div class="flex items-start gap-4 pr-8">
                    <div
                        class="
                            flex
                            size-12
                            shrink-0
                            items-center
                            justify-center
                            rounded-full
                            bg-rino-primary
                            text-rino-primary-text
                        "
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="size-6"
                            aria-hidden="true"
                        >
                            <path d="M12 3a9 9 0 1 0 9 9c-1.8.2-3.3-.4-4.2-1.6-.9-1.2-1.1-2.8-.5-4.2C14.9 6.6 13.7 5.4 13 4c-.3-.4-.6-.8-1-1Z" />
                            <circle cx="8.5" cy="10" r=".8" fill="currentColor" stroke="none" />
                            <circle cx="11" cy="15" r=".8" fill="currentColor" stroke="none" />
                            <circle cx="7" cy="16" r=".8" fill="currentColor" stroke="none" />
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2
                            id="rino-cookie-title"
                            class="text-lg font-bold text-rino-heading"
                        >
                            {{ $cookieConsentTitle ?? 'We use cookies' }}
                        </h2>

                        <p
                            class="
                                mt-2
                                text-sm
                                leading-6
                                text-rino-muted
                            "
                        >
                            {{ $cookieConsentDescription ?? 'We use essential cookies and optional analytics to improve the website.' }}
                        </p>

                        @if (!empty($cookiePrivacyUrl))
                            <a
                                href="{{ $cookiePrivacyUrl }}"
                                class="
                                    mt-2
                                    inline-flex
                                    text-sm
                                    font-semibold
                                    text-rino-primary
                                    no-underline
                                    hover:underline
                                "
                            >
                                {{ $cookiePrivacyLabel ?? 'Privacy Policy' }}
                            </a>
                        @endif
                    </div>
                </div>

                <div
                    class="
                        mt-5
                        grid
                        grid-cols-1
                        gap-3
                        sm:grid-cols-2
                    "
                >
                    @if ($cookieAnalyticsEnabled ?? true)
                        <form
                            method="POST"
                            action="{{ route('cookie-consent.update') }}"
                            class="w-full"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="choice"
                                value="analytics"
                            >

                            <x-ui.button
                                type="submit"
                                variant="normal"
                                class="
                                    min-h-11
                                    w-full
                                    justify-center
                                    px-4
                                    text-sm
                                    font-bold
                                "
                            >
                                {{ $cookieAcceptLabel ?? 'Accept' }}
                            </x-ui.button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('cookie-consent.update') }}"
                            class="w-full"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="choice"
                                value="essential"
                            >

                            <x-ui.button
                                type="submit"
                                variant="normal"
                                class="
                                    min-h-11
                                    w-full
                                    justify-center
                                    px-4
                                    text-sm
                                    font-bold
                                "
                                style="
                                    background:
                                        var(--surface-secondary);

                                    color:
                                        var(--text-heading);
                                "
                            >
                                {{ $cookieRejectLabel ?? 'Reject Optional' }}
                            </x-ui.button>
                        </form>
                    @else
                        <form
                            method="POST"
                            action="{{ route('cookie-consent.update') }}"
                            class="w-full sm:col-span-2"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="choice"
                                value="essential"
                            >

                            <x-ui.button
                                type="submit"
                                variant="normal"
                                class="
                                    min-h-11
                                    w-full
                                    justify-center
                                    px-4
                                    text-sm
                                    font-bold
                                "
                            >
                                {{ $cookieAcceptLabel ?? 'Accept' }}
                            </x-ui.button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    @endif


    <script>
        (() => {
            const root =
                document.documentElement;

            const topStack =
                document.getElementById(
                    'rino-top-stack'
                );

            const header =
                document.querySelector(
                    '[data-rino-header]'
                );

            if (!topStack || !header) {
                return;
            }


            const getAnnouncement =
                () => {
                    const previous =
                        header.previousElementSibling;

                    if (
                        !previous ||
                        previous === header
                    ) {
                        return null;
                    }

                    return previous;
                };


            const syncTopStackMetrics =
                () => {
                    const announcement =
                        getAnnouncement();

                    const headerHeight =
                        header.getBoundingClientRect()
                            .height;

                    const announcementHeight =
                        announcement
                            ? announcement
                                .getBoundingClientRect()
                                .height
                            : 0;

                    const topStackHeight =
                        headerHeight +
                        announcementHeight;

                    root.style.setProperty(
                        '--rino-header-height',
                        `${headerHeight}px`
                    );

                    root.style.setProperty(
                        '--rino-announcement-height',
                        `${announcementHeight}px`
                    );

                    root.style.setProperty(
                        '--rino-top-stack-height',
                        `${topStackHeight}px`
                    );
                };


            const updateHeader =
                () => {
                    header.dataset.scrolled =
                        window.scrollY > 16
                            ? 'true'
                            : 'false';
                };


            const refresh =
                () => {
                    syncTopStackMetrics();
                    updateHeader();
                };


            refresh();


            requestAnimationFrame(
                () => {
                    refresh();

                    requestAnimationFrame(
                        refresh
                    );
                }
            );


            window.addEventListener(
                'load',
                refresh
            );


            window.addEventListener(
                'resize',
                syncTopStackMetrics
            );


            window.addEventListener(
                'orientationchange',
                syncTopStackMetrics
            );


            window.addEventListener(
                'scroll',
                updateHeader,
                {
                    passive: true,
                }
            );


            if (
                typeof ResizeObserver !==
                'undefined'
            ) {
                const observer =
                    new ResizeObserver(
                        syncTopStackMetrics
                    );

                observer.observe(
                    header
                );

                const announcement =
                    getAnnouncement();

                if (announcement) {
                    observer.observe(
                        announcement
                    );
                }
            }
        })();
    </script>




    @if ($cookieConsentEnabled ?? false)

        <script>
            (() => {
                const root =
                    document.querySelector(
                        '[data-cookie-consent-root]'
                    );

                if (!root) {
                    return;
                }

                const panel =
                    root.querySelector(
                        '[data-cookie-consent-panel]'
                    );

                const openButton =
                    root.querySelector(
                        '[data-cookie-preferences-open]'
                    );

                const closeButton =
                    root.querySelector(
                        '[data-cookie-consent-close]'
                    );

                if (
                    !panel
                    ||
                    !openButton
                ) {
                    return;
                }

                const hasChoice =
                    root.dataset.hasChoice ===
                    'true';

                const open =
                    () => {
                        panel.classList.remove(
                            'hidden'
                        );

                        openButton.classList.add(
                            'hidden'
                        );
                    };

                const close =
                    () => {
                        panel.classList.add(
                            'hidden'
                        );

                        if (hasChoice) {
                            openButton.classList.add(
                                'hidden'
                            );

                            return;
                        }

                        openButton.classList.remove(
                            'hidden'
                        );
                    };

                if (hasChoice) {
                    panel.classList.add(
                        'hidden'
                    );

                    openButton.classList.add(
                        'hidden'
                    );
                } else {
                    panel.classList.remove(
                        'hidden'
                    );

                    openButton.classList.add(
                        'hidden'
                    );
                }

                openButton.addEventListener(
                    'click',
                    open
                );

                if (closeButton) {
                    closeButton.addEventListener(
                        'click',
                        close
                    );
                }

                document.addEventListener(
                    'keydown',
                    event => {
                        if (
                            event.key ===
                            'Escape'
                            &&
                            !panel.classList.contains(
                                'hidden'
                            )
                        ) {
                            close();
                        }
                    }
                );

                document
                    .querySelectorAll(
                        '[data-cookie-preferences]'
                    )
                    .forEach(
                        button => {
                            button.addEventListener(
                                'click',
                                event => {
                                    event.preventDefault();
                                    open();
                                }
                            );
                        }
                    );

                window.RinoCookieConsent = {
                    open,
                    close,
                };
            })();
        </script>

    @endif


    @stack('scripts')

</body>

</html>
