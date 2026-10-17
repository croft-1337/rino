@if ($announcementEnabled && ($announcementMessage || $announcementHighlight))

    @php
        $announcementId = sha1(
            $announcementMessage .
            $announcementHighlight .
            $announcementLinkText .
            $announcementLinkUrl
        );
    @endphp

    <div
        id="rino-announcement"
        data-announcement-bar
        data-announcement-id="{{ $announcementId }}"
        class="
            relative
            z-[60]
            h-10
            w-full
            shrink-0
            bg-rino-primary
            text-rino-primary-text
        "
    >

        <div
            class="
                relative
                mx-auto
                flex
                h-full
                max-w-7xl
                items-center
                justify-center
                px-12
                sm:px-14
                lg:px-16
            "
        >

            <div
                class="
                    flex
                    min-w-0
                    items-center
                    justify-center
                    gap-2
                    overflow-hidden
                    whitespace-nowrap
                    text-center
                    text-sm
                    font-medium
                "
            >

                @if ($announcementMessage)

                    <span class="truncate">
                        {{ $announcementMessage }}
                    </span>

                @endif


                @if ($announcementHighlight)

                    <button
                        type="button"
                        data-announcement-code="{{ $announcementHighlight }}"
                        title="Copy code"
                        aria-label="Copy announcement code {{ $announcementHighlight }}"
                        class="
                            inline-flex
                            h-7
                            shrink-0
                            items-center
                            justify-center
                            gap-2
                            bg-white/15
                            px-2.5
                            text-sm
                            font-semibold
                        "
                        style="
                            border-radius:
                                var(--radius-card);
                        "
                    >

                        <span
                            class="
                                underline
                                decoration-current/70
                                underline-offset-[3px]
                            "
                        >
                            {{ $announcementHighlight }}
                        </span>

                        <svg
                            class="
                                h-3.5
                                w-3.5
                                shrink-0
                                opacity-90
                            "
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect
                                x="8"
                                y="8"
                                width="12"
                                height="12"
                                rx="2"
                            />
                            <path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2" />
                        </svg>

                    </button>

                @endif


                @if (
                    $announcementLinkEnabled &&
                    $announcementLinkText &&
                    $announcementLinkUrl
                )

                    <a
                        href="{{ $announcementLinkUrl }}"

                        @if ($announcementOpenNewTab)
                            target="_blank"
                            rel="noopener noreferrer"
                        @endif

                        class="
                            inline-flex
                            shrink-0
                            items-center
                            gap-1
                            text-sm
                            font-semibold
                            transition-opacity
                            hover:opacity-75
                        "
                    >

                        <span>
                            {{ $announcementLinkText }}
                        </span>

                        <svg
                            class="h-3.5 w-3.5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M5 12h14" />
                            <path d="m13 6 6 6-6 6" />
                        </svg>

                    </a>

                @endif

            </div>


            @if ($announcementDismissible)

                <button
                    type="button"
                    data-announcement-dismiss
                    aria-label="Dismiss announcement"
                    class="
                        absolute
                        right-4
                        top-1/2
                        flex
                        h-7
                        w-7
                        -translate-y-1/2
                        items-center
                        justify-center
                        opacity-70
                        transition-opacity
                        hover:opacity-100
                    "
                >

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        aria-hidden="true"
                    >
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>

                </button>

            @endif

        </div>

    </div>

@endif