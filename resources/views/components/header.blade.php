@php

    $headerCurrencyData =

        $currencyData['currencies']

        ?? [];

    $selectedCurrencyData =

        $headerCurrencyData[

            $selectedCurrency

        ]

        ?? null;

@endphp

<header

    id="rino-header"

    data-rino-header

    class="

        relative

        z-50

        w-full

        transition-all

        duration-300

    "

    style="

        background: transparent;

        backdrop-filter: none;

        -webkit-backdrop-filter: none;

        border-bottom: 0 !important;



    "

>

    <div

        class="

            mx-auto

            max-w-7xl

            px-4

            sm:px-6

            lg:px-8

        "

    >

        <div

            class="

                flex

                h-16

                items-center

                justify-between

                gap-5

            "

        >

            <a

                href="/"

                class="

                    flex

                    shrink-0

                    items-center

                    gap-3

                "

            >

                @if ($siteLogo)

                    <img

                        src="{{ $siteLogo }}"

                        alt="{{ $siteName }}"

                        class="

                            h-9

                            w-9

                            object-contain

                        "

                    >

                @endif

                <span

                    class="

                        text-xl

                        font-bold

                        tracking-tight

                        text-rino-heading

                    "

                >

                    {{ $siteName }}

                </span>

            </a>

            <nav

                class="

                    hidden

                    min-w-0

                    flex-1

                    items-center

                    justify-center

                    gap-5

                    lg:flex

                "

            >

                @foreach ($headerStandaloneItems as $item)

                    <a

                        href="{{ $item->url }}"

                        @if ($item->open_new_tab)

                            target="_blank"

                            rel="noopener noreferrer"

                        @endif

                        class="

                            whitespace-nowrap

                            text-sm

                            font-medium

                            text-rino-body

                            transition-colors

                            hover:text-rino-heading

                        "

                    >

                        {{ $item->title }}

                    </a>

                @endforeach

                @foreach ($headerCategories as $category)

                    @php

                        $dropdownId = 'category-' . $category->id;

                    @endphp

                    <div

                        class="relative"

                        data-header-dropdown

                    >

                        <button

                            type="button"

                            data-dropdown-trigger="{{ $dropdownId }}"

                            class="

                                flex

                                items-center

                                gap-1.5

                                whitespace-nowrap

                                text-sm

                                font-medium

                                text-rino-body

                                transition-colors

                                hover:text-rino-heading

                            "

                        >

                            <span>

                                {{ $category->name }}

                            </span>

                            <svg

                                data-dropdown-chevron

                                class="

                                    h-3.5

                                    w-3.5

                                    shrink-0

                                    transition-transform

                                    duration-200

                                "

                                viewBox="0 0 20 20"

                                fill="currentColor"

                                aria-hidden="true"

                            >

                                <path

                                    fill-rule="evenodd"

                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"

                                    clip-rule="evenodd"

                                />

                            </svg>

                        </button>

                        <div

                            data-dropdown-menu="{{ $dropdownId }}"

                            class="

                                invisible

                                absolute

                                left-0

                                top-full

                                z-50

                                mt-3

                                w-56

                                translate-y-1

                                opacity-0

                                transition-all

                                duration-200

                            "

                        >

                            <div

                                class="

                                    bg-rino-surface

                                    p-2

                                    shadow-xl

                                "

                                style="

                                    border-radius:

                                    var(--radius-card);

                                "

                            >

                                @foreach ($category->pages as $item)

                                    <a

                                        href="{{ $item->url }}"

                                        @if ($item->open_new_tab)

                                            target="_blank"

                                            rel="noopener noreferrer"

                                        @endif

                                        class="

                                            block

                                            px-3

                                            py-2.5

                                            text-sm

                                            font-medium

                                            text-rino-body

                                            transition-colors

                                            hover:bg-rino-surface-secondary

                                            hover:text-rino-heading

                                        "

                                        style="

                                            border-radius:

                                            var(--radius-button);

                                        "

                                    >

                                        {{ $item->title }}

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            </nav>

            <div

                class="

                    flex

                    shrink-0

                    items-center

                    gap-2

                "

            >

                @if ($headerSocialLinks->isNotEmpty())

                    <div

                        class="

                            hidden

                            items-center

                            gap-3

                            lg:flex

                        "

                    >

                        @foreach ($headerSocialLinks as $social)

                            <a

                                href="{{ $social->url }}"

                                target="_blank"

                                rel="noopener noreferrer"

                                aria-label="{{ ucfirst($social->platform) }}"

                                class="

                                    flex

                                    h-9

                                    w-6

                                    shrink-0

                                    items-center

                                    justify-center

                                    text-rino-muted

                                    transition-colors

                                    duration-200

                                    hover:text-rino-primary

                                "

                            >

                                <x-ui.social-icon

                                    :platform="$social->platform"

                                    class="h-5 w-5"

                                />

                            </a>

                        @endforeach

                    </div>

                @endif

                @if ($allowThemeSwitch)

                    <button

                        type="button"

                        data-theme-toggle

                        aria-label="Toggle light and dark mode"

                        class="

                            flex

                            h-9

                            w-9

                            shrink-0

                            items-center

                            justify-center

                            text-rino-body

                            transition-colors

                            duration-200

                            hover:text-rino-heading

                        "

                    >

                        <svg

                            data-theme-light-icon

                            class="

                                hidden

                                h-5

                                w-5

                            "

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="1.8"

                            stroke-linecap="round"

                            stroke-linejoin="round"

                        >

                            <circle cx="12" cy="12" r="4" />

                            <path d="M12 2v2" />

                            <path d="M12 20v2" />

                            <path d="m4.93 4.93 1.41 1.41" />

                            <path d="m17.66 17.66 1.41 1.41" />

                            <path d="M2 12h2" />

                            <path d="M20 12h2" />

                            <path d="m6.34 17.66-1.41 1.41" />

                            <path d="m19.07 4.93-1.41 1.41" />

                        </svg>

                        <svg

                            data-theme-dark-icon

                            class="

                                h-5

                                w-5

                            "

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="1.8"

                            stroke-linecap="round"

                            stroke-linejoin="round"

                        >

                            <path

                                d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"

                            />

                        </svg>

                    </button>

                @endif

                @if (count($enabledCurrencies) > 1)

                    <div

                        class="

                            relative

                            hidden

                            lg:block

                        "

                        data-header-dropdown

                    >

                        <button

                            type="button"

                            data-dropdown-trigger="currency-dropdown"

                            class="

                                flex

                                h-9

                                items-center

                                justify-center

                                gap-1.5

                                whitespace-nowrap

                                px-2

                                text-sm

                                font-medium

                                text-rino-body

                                transition-colors

                                hover:text-rino-heading

                            "

                        >

                            @if (!empty($selectedCurrencyData['flag']))

                                <img

                                    src="{{ $selectedCurrencyData['flag'] }}"

                                    alt=""

                                    class="

                                        h-4

                                        w-5

                                        shrink-0

                                        rounded-sm

                                        object-cover

                                    "

                                >

                            @endif

                            <span>

                                {{ $selectedCurrency }}

                            </span>

                            <svg

                                data-dropdown-chevron

                                class="

                                    h-3.5

                                    w-3.5

                                    shrink-0

                                    transition-transform

                                    duration-200

                                "

                                viewBox="0 0 20 20"

                                fill="currentColor"

                                aria-hidden="true"

                            >

                                <path

                                    fill-rule="evenodd"

                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"

                                    clip-rule="evenodd"

                                />

                            </svg>

                        </button>

                        <div

                            data-dropdown-menu="currency-dropdown"

                            class="

                                invisible

                                absolute

                                right-0

                                top-full

                                z-50

                                mt-3

                                {{ count($enabledCurrencies) > 5 ? 'w-56' : 'w-28' }}

                                translate-y-1

                                opacity-0

                                transition-all

                                duration-200

                            "

                        >

                            <div

                                class="

                                    bg-rino-surface

                                    p-2

                                    shadow-xl

                                    {{ count($enabledCurrencies) > 5

                                        ? 'grid grid-cols-2 gap-1'

                                        : 'space-y-1' }}

                                "

                                style="

                                    border-radius:

                                    var(--radius-card);

                                "

                            >

                                @foreach ($enabledCurrencies as $currency)

                                    <form

                                        method="POST"

                                        action="{{ route('currency.switch') }}"

                                    >

                                        @csrf

                                        <input

                                            type="hidden"

                                            name="currency"

                                            value="{{ $currency }}"

                                        >

                                        <button

                                            type="submit"

                                            class="

                                                flex

                                                w-full

                                                items-center

                                                gap-2

                                                px-3

                                                py-2.5

                                                text-left

                                                text-sm

                                                font-medium

                                                transition-colors

                                                hover:bg-rino-surface-secondary

                                                hover:text-rino-heading

                                                {{ $selectedCurrency === $currency

                                                    ? 'text-rino-primary'

                                                    : 'text-rino-body' }}

                                            "

                                            style="

                                                border-radius:

                                                var(--radius-button);

                                            "

                                        >

                                            @php

                                                $itemCurrencyData =

                                                    $headerCurrencyData[

                                                        $currency

                                                    ]

                                                    ?? null;

                                            @endphp

                                            @if (!empty($itemCurrencyData['flag']))

                                                <img

                                                    src="{{ $itemCurrencyData['flag'] }}"

                                                    alt=""

                                                    class="

                                                        h-4

                                                        w-5

                                                        shrink-0

                                                        rounded-sm

                                                        object-cover

                                                    "

                                                >

                                            @endif

                                            <span>

                                                {{ $currency }}

                                            </span>

                                        </button>

                                    </form>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @elseif (count($enabledCurrencies) === 1)

                    <span

                        class="

                            hidden

                            items-center

                            gap-2

                            px-2

                            text-sm

                            font-medium

                            text-rino-body

                            lg:flex

                        "

                    >

                        @if (!empty($selectedCurrencyData['flag']))

                            <img

                                src="{{ $selectedCurrencyData['flag'] }}"

                                alt=""

                                class="

                                    h-4

                                    w-5

                                    shrink-0

                                    rounded-sm

                                    object-cover

                                "

                            >

                        @endif

                        <span>

                            {{ $selectedCurrency }}

                        </span>

                    </span>

                @endif

                @if (!empty($clientAreaLinks))

                    <div

                        class="

                            relative

                            hidden

                            lg:block

                        "

                        data-header-dropdown

                    >

                        <x-ui.button

                            variant="icon-circle"

                            data-dropdown-trigger="client-area-dropdown"

                        >

                            {{ $clientAreaLabel }}

                            <x-slot:icon>

                                <svg

                                    data-dropdown-chevron

                                    class="

                                        h-[15px]

                                        w-[15px]

                                        transition-transform

                                        duration-200

                                    "

                                    viewBox="0 0 24 24"

                                    fill="none"

                                    stroke="currentColor"

                                    stroke-width="2"

                                    stroke-linecap="round"

                                    stroke-linejoin="round"

                                >

                                    <path d="M12 5v14" />

                                    <path d="m6 13 6 6 6-6" />

                                </svg>

                            </x-slot:icon>

                        </x-ui.button>

                        <div

                            data-dropdown-menu="client-area-dropdown"

                            class="

                                invisible

                                absolute

                                right-0

                                top-full

                                z-50

                                mt-3

                                w-60

                                translate-y-1

                                opacity-0

                                transition-all

                                duration-200

                            "

                        >

                            <div

                                class="

                                    bg-rino-surface

                                    p-2

                                    shadow-xl

                                "

                                style="

                                    border-radius:

                                    var(--radius-card);

                                "

                            >

                                @foreach ($clientAreaLinks as $link)

                                    <a

                                        href="{{ $link['url'] }}"

                                        @if (!empty($link['new_tab']))

                                            target="_blank"

                                            rel="noopener noreferrer"

                                        @endif

                                        class="

                                            flex

                                            items-center

                                            gap-3

                                            px-3

                                            py-2.5

                                            text-sm

                                            text-rino-body

                                            transition-colors

                                            hover:bg-rino-surface-secondary

                                            hover:text-rino-heading

                                        "

                                        style="

                                            border-radius:

                                            var(--radius-button);

                                        "

                                    >

                                        @if (

                                            ($link['icon'] ?? 'none')

                                            !== 'none'

                                        )

                                            <span

                                                class="

                                                    flex

                                                    h-5

                                                    w-5

                                                    shrink-0

                                                    items-center

                                                    justify-center

                                                    text-rino-muted

                                                "

                                            >

                                                @switch(

                                                    $link['icon']

                                                    ?? 'none'

                                                )

                                                    @case('credit-card')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <rect

                                                                x="2"

                                                                y="5"

                                                                width="20"

                                                                height="14"

                                                                rx="2"

                                                            />

                                                            <path d="M2 10h20" />

                                                        </svg>

                                                        @break

                                                    @case('server')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <rect x="2" y="3" width="20" height="8" rx="2" />

                                                            <rect x="2" y="13" width="20" height="8" rx="2" />

                                                            <path d="M6 7h.01" />

                                                            <path d="M6 17h.01" />

                                                        </svg>

                                                        @break

                                                    @case('gamepad')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <path d="M6 11h4" />

                                                            <path d="M8 9v4" />

                                                            <path d="M15 12h.01" />

                                                            <path d="M18 10h.01" />

                                                            <path d="M17.32 5H6.68A4 4 0 0 0 2.8 8l-1.12 6.72A3 3 0 0 0 4.64 18h.72a3 3 0 0 0 2.4-1.2L9 15h6l1.24 1.8a3 3 0 0 0 2.4 1.2h.72a3 3 0 0 0 2.96-3.28L21.2 8a4 4 0 0 0-3.88-3Z" />

                                                        </svg>

                                                        @break

                                                    @case('dashboard')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <rect x="3" y="3" width="7" height="7" rx="1" />

                                                            <rect x="14" y="3" width="7" height="7" rx="1" />

                                                            <rect x="3" y="14" width="7" height="7" rx="1" />

                                                            <rect x="14" y="14" width="7" height="7" rx="1" />

                                                        </svg>

                                                        @break

                                                    @case('support')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <circle cx="12" cy="12" r="9" />

                                                            <path d="M9.1 9a3 3 0 1 1 5.8 1c-.4 1-1.4 1.4-2 2-.5.5-.9 1-.9 2" />

                                                            <path d="M12 18h.01" />

                                                        </svg>

                                                        @break

                                                    @case('globe')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <circle cx="12" cy="12" r="9" />

                                                            <path d="M3 12h18" />

                                                            <path d="M12 3a15 15 0 0 1 0 18" />

                                                            <path d="M12 3a15 15 0 0 0 0 18" />

                                                        </svg>

                                                        @break

                                                    @case('user-circle')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <circle cx="12" cy="12" r="9" />

                                                            <circle cx="12" cy="9" r="3" />

                                                            <path d="M6.5 19c1.2-2.6 3-4 5.5-4s4.3 1.4 5.5 4" />

                                                        </svg>

                                                        @break

                                                    @case('login')

                                                    @case('external-link')

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <path d="M15 3h6v6" />

                                                            <path d="m10 14 11-11" />

                                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />

                                                        </svg>

                                                        @break

                                                    @default

                                                        <svg

                                                            class="h-[18px] w-[18px]"

                                                            viewBox="0 0 24 24"

                                                            fill="none"

                                                            stroke="currentColor"

                                                            stroke-width="1.8"

                                                            stroke-linecap="round"

                                                            stroke-linejoin="round"

                                                        >

                                                            <circle cx="12" cy="8" r="4" />

                                                            <path d="M4 21a8 8 0 0 1 16 0" />

                                                        </svg>

                                                @endswitch

                                            </span>

                                        @endif

                                        <span

                                            class="

                                                min-w-0

                                                flex-1

                                                truncate

                                                font-medium

                                            "

                                        >

                                            {{ $link['label'] }}

                                        </span>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif

                <button

                    type="button"

                    data-mobile-menu-trigger

                    aria-label="Open menu"

                    aria-expanded="false"

                    class="

                        flex

                        h-9

                        w-9

                        items-center

                        justify-center

                        text-rino-body

                        transition-colors

                        hover:text-rino-heading

                        lg:hidden

                    "

                >

                    <svg

                        data-mobile-menu-open-icon

                        class="h-5 w-5"

                        viewBox="0 0 24 24"

                        fill="none"

                        stroke="currentColor"

                        stroke-width="2"

                        stroke-linecap="round"

                    >

                        <path d="M4 6h16" />

                        <path d="M4 12h16" />

                        <path d="M4 18h16" />

                    </svg>

                    <svg

                        data-mobile-menu-close-icon

                        class="hidden h-5 w-5"

                        viewBox="0 0 24 24"

                        fill="none"

                        stroke="currentColor"

                        stroke-width="2"

                        stroke-linecap="round"

                    >

                        <path d="M18 6 6 18" />

                        <path d="m6 6 12 12" />

                    </svg>

                </button>

            </div>

        </div>

    </div>

    <div

        data-mobile-menu

        class="

            invisible

            absolute

            inset-x-0

            top-full

            max-h-0

            overflow-hidden

            bg-rino-surface

            opacity-0

            shadow-xl

            transition-all

            duration-300

            lg:hidden

        "

    >

        <nav

            class="

                mx-auto

                max-w-7xl

                space-y-1

                px-4

                py-4

                sm:px-6

            "

        >

            @foreach ($headerStandaloneItems as $item)

                <a

                    href="{{ $item->url }}"

                    @if ($item->open_new_tab)

                        target="_blank"

                        rel="noopener noreferrer"

                    @endif

                    class="

                        block

                        px-3

                        py-3

                        text-sm

                        font-medium

                        text-rino-body

                        transition-colors

                        hover:bg-rino-surface-secondary

                        hover:text-rino-heading

                    "

                    style="

                        border-radius:

                        var(--radius-button);

                    "

                >

                    {{ $item->title }}

                </a>

            @endforeach

            @foreach ($headerCategories as $category)

                @php

                    $mobileDropdownId =

                        'mobile-category-' .

                        $category->id;

                @endphp

                <div>

                    <button

                        type="button"

                        data-mobile-dropdown-trigger="{{ $mobileDropdownId }}"

                        class="

                            flex

                            w-full

                            items-center

                            justify-between

                            px-3

                            py-3

                            text-sm

                            font-medium

                            text-rino-body

                            transition-colors

                            hover:bg-rino-surface-secondary

                            hover:text-rino-heading

                        "

                    >

                        {{ $category->name }}

                        <svg

                            data-mobile-chevron

                            class="

                                h-4

                                w-4

                                transition-transform

                                duration-200

                            "

                            viewBox="0 0 20 20"

                            fill="currentColor"

                        >

                            <path

                                fill-rule="evenodd"

                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"

                                clip-rule="evenodd"

                            />

                        </svg>

                    </button>

                    <div

                        data-mobile-dropdown="{{ $mobileDropdownId }}"

                        class="

                            max-h-0

                            overflow-hidden

                            opacity-0

                            transition-all

                            duration-300

                        "

                    >

                        <div

                            class="

                                ml-3

                                space-y-1

                                py-1

                                pl-3

                            "

                        >

                            @foreach ($category->pages as $item)

                                <a

                                    href="{{ $item->url }}"

                                    @if ($item->open_new_tab)

                                        target="_blank"

                                        rel="noopener noreferrer"

                                    @endif

                                    class="

                                        block

                                        px-3

                                        py-2.5

                                        text-sm

                                        text-rino-muted

                                        transition-colors

                                        hover:bg-rino-surface-secondary

                                        hover:text-rino-heading

                                    "

                                >

                                    {{ $item->title }}

                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endforeach

            @if (count($enabledCurrencies) > 1)

                <div class="pt-2">

                    <button

                        type="button"

                        data-mobile-dropdown-trigger="mobile-currency-dropdown"

                        class="

                            flex

                            w-full

                            items-center

                            justify-between

                            px-3

                            py-3

                            text-sm

                            font-medium

                            text-rino-body

                        "

                    >

                        <span

                            class="

                                flex

                                items-center

                                gap-2

                            "

                        >

                            @if (!empty($selectedCurrencyData['flag']))

                                <img

                                    src="{{ $selectedCurrencyData['flag'] }}"

                                    alt=""

                                    class="

                                        h-4

                                        w-5

                                        shrink-0

                                        rounded-sm

                                        object-cover

                                    "

                                >

                            @endif

                            <span>

                                {{ $selectedCurrency }}

                            </span>

                        </span>

                        <svg

                            data-mobile-chevron

                            class="

                                h-4

                                w-4

                                transition-transform

                                duration-200

                            "

                            viewBox="0 0 20 20"

                            fill="currentColor"

                        >

                            <path

                                fill-rule="evenodd"

                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"

                                clip-rule="evenodd"

                            />

                        </svg>

                    </button>

                    <div

                        data-mobile-dropdown="mobile-currency-dropdown"

                        class="

                            max-h-0

                            overflow-hidden

                            opacity-0

                            transition-all

                            duration-300

                        "

                    >

                        <div

                            class="

                                py-2

                                {{ count($enabledCurrencies) > 5

                                    ? 'grid grid-cols-2 gap-1'

                                    : 'space-y-1' }}

                            "

                        >

                            @foreach ($enabledCurrencies as $currency)

                                <form

                                    method="POST"

                                    action="{{ route('currency.switch') }}"

                                >

                                    @csrf

                                    <input

                                        type="hidden"

                                        name="currency"

                                        value="{{ $currency }}"

                                    >

                                    <button

                                        type="submit"

                                        class="

                                            flex

                                            w-full

                                            items-center

                                            gap-2

                                            px-3

                                            py-2.5

                                            text-left

                                            text-sm

                                            font-medium

                                            {{ $selectedCurrency === $currency

                                                ? 'text-rino-primary'

                                                : 'text-rino-muted' }}

                                        "

                                    >

                                        @php

                                            $itemCurrencyData =

                                                $headerCurrencyData[

                                                    $currency

                                                ]

                                                ?? null;

                                        @endphp

                                        @if (!empty($itemCurrencyData['flag']))

                                            <img

                                                src="{{ $itemCurrencyData['flag'] }}"

                                                alt=""

                                                class="

                                                    h-4

                                                    w-5

                                                    shrink-0

                                                    rounded-sm

                                                    object-cover

                                                "

                                            >

                                        @endif

                                        <span>

                                            {{ $currency }}

                                        </span>

                                    </button>

                                </form>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

            @if (!empty($clientAreaLinks))

                <div class="pt-2">

                    <button

                        type="button"

                        data-mobile-dropdown-trigger="mobile-client-area"

                        class="

                            flex

                            w-full

                            items-center

                            justify-between

                            bg-rino-primary

                            px-3

                            py-3

                            text-sm

                            font-semibold

                            text-rino-primary-text

                        "

                        style="

                            border-radius:

                            var(--radius-button);

                        "

                    >

                        {{ $clientAreaLabel }}

                        <svg

                            data-mobile-chevron

                            class="

                                h-4

                                w-4

                                transition-transform

                                duration-200

                            "

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="2"

                            stroke-linecap="round"

                            stroke-linejoin="round"

                        >

                            <path d="M12 5v14" />

                            <path d="m6 13 6 6 6-6" />

                        </svg>

                    </button>

                    <div

                        data-mobile-dropdown="mobile-client-area"

                        class="

                            max-h-0

                            overflow-hidden

                            opacity-0

                            transition-all

                            duration-300

                        "

                    >

                        <div class="space-y-1 py-2">

                            @foreach ($clientAreaLinks as $link)

                                <a

                                    href="{{ $link['url'] }}"

                                    @if (!empty($link['new_tab']))

                                        target="_blank"

                                        rel="noopener noreferrer"

                                    @endif

                                    class="

                                        block

                                        px-3

                                        py-2.5

                                        text-sm

                                        text-rino-muted

                                        transition-colors

                                        hover:bg-rino-surface-secondary

                                        hover:text-rino-heading

                                    "

                                >

                                    {{ $link['label'] }}

                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

            @if ($headerSocialLinks->isNotEmpty())

                <div

                    class="

                        flex

                        items-center

                        gap-4

                        px-3

                        pt-3

                    "

                >

                    @foreach ($headerSocialLinks as $social)

                        <a

                            href="{{ $social->url }}"

                            target="_blank"

                            rel="noopener noreferrer"

                            aria-label="{{ ucfirst($social->platform) }}"

                            class="

                                flex

                                items-center

                                justify-center

                                text-rino-muted

                                transition-colors

                                hover:text-rino-primary

                            "

                        >

                            <x-ui.social-icon

                                :platform="$social->platform"

                                class="h-5 w-5"

                            />

                        </a>

                    @endforeach

                </div>

            @endif

        </nav>

    </div>

</header>

<style>
    #rino-header {
        box-shadow: none;
    }

    #rino-header.rino-header-scrolled {
        box-shadow: inset 0 -1px 0 color-mix(in srgb, var(--border) 35%, transparent);
    }

    .dark #rino-header,

    [data-theme="dark"] #rino-header {

        box-shadow: none !important;

    }

</style>

<script>

    (() => {

        const header = document.querySelector('[data-rino-header]');

        if (!header) {

            return;

        }

const updateHeader = () => {

    const scrolled = window.scrollY > 12;

    header.classList.toggle('rino-header-scrolled', scrolled);

    if (scrolled) {

        header.style.background = 'color-mix(in srgb, var(--surface) 88%, transparent)';

        header.style.backdropFilter = 'blur(10px)';

        header.style.webkitBackdropFilter = 'blur(10px)';

    } else {

        header.style.background = 'transparent';

        header.style.backdropFilter = 'none';

        header.style.webkitBackdropFilter = 'none';

    }

};

        updateHeader();

        window.addEventListener(

            'scroll',

            updateHeader,

            {

                passive: true,

            }

        );

    })();

</script>
