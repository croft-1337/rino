@php
    use Illuminate\Support\Facades\Storage;
@endphp

<footer class="rino-footer bg-rino-surface">
    <div
        class="
            mx-auto
            max-w-7xl
            px-4
            py-12
            sm:px-6
            lg:px-8
        "
    >
        <div
            class="
                flex
                flex-col
                gap-10
                md:flex-row
                md:items-start
            "
        >
            <div
                class="
                    w-full
                    shrink-0
                    md:w-[280px]
                    lg:w-[240px]
                "
            >
                @if ($footerShowSiteLogo)
                    <a
                        href="/"
                        class="
                            inline-flex
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
                @endif

                @if (!empty($footerDescription))
                    <p
                        class="
                            mb-5
                            mt-5
                            text-[15px]
                            leading-relaxed
                            text-rino-muted
                        "
                    >
                        {{ $footerDescription }}
                    </p>
                @endif

                @if ($footerSocialLinks->isNotEmpty())
                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            gap-4
                        "
                    >
                        @foreach ($footerSocialLinks as $social)
                            <a
                                href="{{ $social->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="{{ ucfirst($social->platform) }}"
                                class="
                                    flex
                                    h-7
                                    w-6
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
                                    class="h-6 w-6"
                                />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($footerCategories->isNotEmpty())
                <div
                    class="
                        flex
                        flex-1
                        flex-wrap
                        gap-x-8
                        gap-y-8
                        md:justify-end
                    "
                >
                    @foreach ($footerCategories as $category)
                        <div
                            class="
                                min-w-[140px]
                                flex-1
                                max-w-[180px]
                            "
                        >
                            <h3
                                class="
                                    mb-4
                                    text-[15px]
                                    font-semibold
                                    text-rino-heading
                                "
                            >
                                {{ $category->name }}
                            </h3>

                            <ul class="space-y-2.5">
                                @foreach ($category->pages as $item)
                                    <li>
                                        <a
                                            href="{{ $item->url }}"
                                            @if ($item->open_new_tab)
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            @endif
                                            class="
                                                text-[15px]
                                                leading-relaxed
                                                text-rino-muted
                                                transition-colors
                                                duration-200
                                                hover:text-rino-primary
                                            "
                                        >
                                            {{ $item->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div
            class="
                mt-8
                border-t
                border-rino-border
                pt-5
            "
        >
            <div
                class="
                    flex
                    flex-col
                    gap-4
                    md:flex-row
                    md:items-center
                    md:justify-between
                "
            >
                <p
                    class="
                        text-sm
                        leading-relaxed
                        text-rino-muted
                    "
                >
                    {{ $footerCopyright }}
                </p>

                @if (
                    $footerShowPayments &&
                    !empty($footerPaymentMethods)
                )
                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            gap-2
                            md:justify-end
                        "
                    >
                        @foreach ($footerPaymentMethods as $payment)
                            @php
                                $paymentLogo =
                                    $payment['logo'] ?? null;
                            @endphp

                            @if ($paymentLogo)
                                <div
                                    class="
                                        flex
                                        h-9
                                        w-[86px]
                                        shrink-0
                                        items-center
                                        justify-center
                                        overflow-hidden
                                        border
                                        border-rino-border
                                        bg-rino-surface-secondary
                                        px-3
                                    "
                                    style="
                                        border-radius: 8px;
                                    "
                                >
                                    <img
                                        src="{{ Storage::url($paymentLogo) }}"
                                        alt="{{ $payment['alt'] ?? 'Payment method' }}"
                                        style="
                                            display: block;
                                            width: auto;
                                            height: auto;
                                            max-width: 64px;
                                            max-height: 20px;
                                            object-fit: contain;
                                            object-position: center;
                                        "
                                    >
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>

<style>
    .rino-footer {
        box-shadow:
            inset 0 1px 0
            color-mix(
                in srgb,
                var(--border) 35%,
                transparent
            );
    }

    .dark .rino-footer,
    [data-theme="dark"] .rino-footer {
        box-shadow: none;
    }
</style>