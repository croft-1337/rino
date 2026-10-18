@php
    $enabled = $section['enabled'] ?? true;

    if (!$enabled) {
        return;
    }

    $layout = $section['layout'] ?? 'cards';
    $cardStyle = $section['card_style'] ?? 'classic';
    $alignment = $section['alignment'] ?? 'left';
    $isCentered = $alignment === 'center';
    $priceDisplay = $section['price_display'] ?? 'monthly-equivalent';
    $showCycleDiscount = (bool) ($section['show_cycle_discount'] ?? true);

    $billingCycles = collect($section['billing_cycles'] ?? [])
        ->filter(fn ($cycle) =>
            (bool) ($cycle['enabled'] ?? true)
            && filled($cycle['id'] ?? null)
            && filled($cycle['name'] ?? null)
        )
        ->values();

    $defaultCycle = $billingCycles->first(
        fn ($cycle) => (bool) ($cycle['default'] ?? false)
    ) ?? $billingCycles->first();

    $defaultCycleId = $defaultCycle['id'] ?? null;

    $plans = collect($section['plans'] ?? [])
        ->filter(fn ($plan) =>
            (bool) ($plan['enabled'] ?? true)
            && filled($plan['id'] ?? null)
            && filled($plan['name'] ?? null)
        )
        ->values();

    if ($plans->isEmpty()) {
        return;
    }

    $plansId = 'rino-plans-' . \Illuminate\Support\Str::random(8);

    $planPayload = $plans
        ->map(function ($plan) {
            $prices = collect($plan['prices'] ?? [])
                ->filter(fn ($price) =>
                    filled($price['cycle_id'] ?? null)
                    && is_numeric($price['price'] ?? null)
                )
                ->mapWithKeys(fn ($price) => [
                    (string) $price['cycle_id'] => [
                        'price' => (float) $price['price'],
                        'checkout_url' => $price['checkout_url'] ?? null,
                    ],
                ])
                ->all();

            return [
                'id' => (string) $plan['id'],
                'prices' => $prices,
                'selector_matches' => collect(
                    $plan['selector_matches']
                    ?? []
                )
                    ->filter(
                        fn ($match) =>
                            is_string($match)
                            &&
                            str_contains(
                                $match,
                                '::'
                            )
                    )
                    ->values()
                    ->all(),
            ];
        })
        ->values()
        ->all();

    $cyclePayload = $billingCycles
        ->map(fn ($cycle) => [
            'id' => (string) $cycle['id'],
            'name' => $cycle['name'],
            'short_label' => filled($cycle['short_label'] ?? null)
                ? $cycle['short_label']
                : null,
            'months' => max(1, (int) ($cycle['months'] ?? 1)),
            'default' => (bool) ($cycle['default'] ?? false),
        ])
        ->values()
        ->all();

    $currencyService = app(\App\Support\Currency\CurrencyService::class);
    $selectedCurrency = $currencyService->selected();
    $currencyRate = $currencyService->rate($selectedCurrency) ?? 1.0;
    $currencySymbol = $currencyService->symbol($selectedCurrency);
    $currencyDecimals = $currencyService->decimals($selectedCurrency);
@endphp

<section
    id="{{ $plansId }}"
    data-rino-plans
    data-layout="{{ $layout }}"
    data-card-style="{{ $cardStyle }}"
    data-alignment="{{ $alignment }}"
    class="bg-rino-background px-4 pb-6 pt-2 sm:px-6 lg:px-8"
>
    <div class="mx-auto w-full max-w-7xl">

        @if ($billingCycles->count() > 1)
            <div
                data-plans-fallback-billing
                data-visible="false"
                class="
                    mb-5 hidden w-full justify-start sm:justify-end
                    data-[visible=true]:flex
                "
            >
                <div
                    class="
                        inline-flex max-w-full items-center gap-1 overflow-x-auto
                        rounded-full border border-rino-border bg-rino-surface p-1
                    "
                >
                    @foreach ($billingCycles as $cycle)
                        <button
                            type="button"
                            data-plans-cycle
                            data-cycle-id="{{ $cycle['id'] }}"
                            data-selected="{{ (string) $cycle['id'] === (string) $defaultCycleId ? 'true' : 'false' }}"
                            class="
                                inline-flex min-h-10 shrink-0 items-center justify-center
                                rounded-full px-4 text-sm font-semibold text-rino-body
                                transition hover:text-rino-heading
                                data-[selected=true]:bg-rino-primary
                                data-[selected=true]:text-rino-primary-text
                            "
                        >
                            {{ $cycle['name'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($layout === 'rows')
            <div class="flex w-full flex-col gap-4">
                @foreach ($plans as $plan)
                    @php
                        $hasVisual =
                            ($plan['visual_type'] ?? 'none') === 'upload'
                            && filled($plan['image'] ?? null);

                        $specs = collect($plan['specs'] ?? [])
                            ->filter(fn ($spec) => filled($spec['label'] ?? null))
                            ->values();

                        $popular = (bool) ($plan['popular'] ?? false);

                        $recommended =
                            !$popular && (bool) ($plan['recommended'] ?? false);

                        $hasRowBadge = $popular || $recommended;
                    @endphp

                    <article
                        data-plan-card
                        data-plan-id="{{ $plan['id'] }}"
                        class="
                            relative w-full overflow-hidden rounded-[var(--radius-card)]
                            bg-rino-surface px-4 py-5 sm:px-5 lg:px-6
                        "
                    >
                        @if ($hasRowBadge)
                            <div
                                aria-hidden="true"
                                class="
                                    pointer-events-none absolute left-0 top-0 z-20 size-24
                                    overflow-hidden
                                "
                            >
                                <span
                                    class="
                                        absolute flex h-6 items-center justify-center
                                        whitespace-nowrap bg-rino-primary text-center
                                        font-extrabold uppercase leading-none tracking-wide
                                        text-rino-primary-text

                                        {{ $popular
                                            ? '-left-[1.9rem] top-[1.05rem] w-28 -rotate-45 text-[0.625rem]'
                                            : '-left-[2.55rem] top-[1.3rem] w-36 -rotate-45 text-[0.55rem]'
                                        }}
                                    "
                                >
                                    {{ $popular ? 'Popular' : 'Recommended' }}
                                </span>
                            </div>
                        @endif

                        <div
                            class="
                                grid min-w-0 items-center gap-5
                                md:grid-cols-[minmax(0,1fr)_auto]
                                lg:grid-cols-[210px_minmax(0,1fr)_135px] lg:gap-x-5
                                xl:grid-cols-[225px_minmax(0,1fr)_145px_205px] xl:gap-x-0
                            "
                        >
                            <div
                                class="
                                    flex min-w-0 items-center gap-3
                                    {{ $hasRowBadge ? 'pl-7 sm:pl-8 lg:pl-6' : '' }}
                                    lg:min-h-16 lg:border-r lg:border-rino-border lg:pr-5
                                "
                            >
                                @if ($hasVisual)
                                    <span
                                        class="
                                            flex size-10 shrink-0 items-center justify-center
                                            overflow-hidden rounded-md sm:size-11
                                        "
                                    >
                                        <img
                                            src="{{ \App\Support\AssetUrl::resolve($plan['image']) }}"
                                            alt=""
                                            class="size-full object-contain"
                                        >
                                    </span>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <h3
                                        class="
                                            break-words text-base font-bold leading-snug
                                            text-rino-heading
                                        "
                                    >
                                        {{ $plan['name'] }}
                                    </h3>

                                    @if (filled($plan['description'] ?? null))
                                        <p
                                            class="
                                                mt-1 line-clamp-2 text-sm leading-relaxed
                                                text-rino-muted
                                            "
                                        >
                                            {{ $plan['description'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="
                                    grid min-w-0 grid-cols-2 gap-x-4 gap-y-3
                                    sm:grid-cols-3
                                    md:col-span-2
                                    lg:col-span-1 lg:grid-cols-3 lg:px-1
                                    xl:px-5
                                "
                            >
                                @foreach ($specs as $spec)
                                    <div
                                        class="
                                            flex min-w-0 items-start gap-2 text-sm font-medium
                                            leading-[1.3] text-rino-body
                                        "
                                    >
                                        <span
                                            class="
                                                mt-[0.1rem] flex size-[1.125rem] shrink-0
                                                items-center justify-center text-rino-primary
                                            "
                                        >
                                            <x-sections.partials.plan-icon
                                                :name="$spec['icon'] ?? 'check'"
                                                class="size-full"
                                            />
                                        </span>

                                        <span
                                            class="
                                                min-w-0 max-w-[8rem] leading-snug
                                                [overflow-wrap:normal] [word-break:normal]
                                            "
                                        >
                                            {{ $spec['label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="
                                    flex min-w-0 flex-col justify-center
                                    md:items-end
                                    lg:min-h-16 lg:items-start lg:border-l lg:border-rino-border lg:pl-5
                                    xl:pl-6
                                "
                            >
                                <div class="flex items-end gap-1.5">
                                    <span
                                        class="
                                            text-[1.7rem] font-bold leading-none
                                            tracking-tight text-rino-primary
                                        "
                                    >
                                        <span>{{ $currencySymbol }}</span><span data-plan-price>--</span>
                                    </span>

                                    <span
                                        data-plan-price-cycle
                                        class="
                                            pb-0.5 text-sm font-semibold leading-none
                                            text-rino-muted
                                        "
                                    ></span>
                                </div>

                                <span
                                    data-plan-discount
                                    class="
                                        mt-1 hidden text-xs font-bold leading-none
                                        text-rino-primary
                                    "
                                ></span>
                            </div>

                            <div
                                class="
                                    flex w-full justify-start
                                    md:justify-end
                                    lg:col-span-3
                                    xl:col-span-1 xl:pl-5
                                "
                            >
                                <a
                                    data-plan-order
                                    href="#"
                                    class="
                                        inline-flex min-h-11 w-full items-center justify-between
                                        gap-3 rounded-[var(--radius-button)] bg-rino-primary
                                        py-1.5 pl-5 pr-1.5 text-sm font-bold
                                        text-rino-primary-text no-underline transition-opacity
                                        hover:opacity-90
                                        aria-disabled:pointer-events-none aria-disabled:opacity-40
                                        sm:w-52
                                        xl:w-full
                                    "
                                >
                                    <span data-plan-order-label>Order Now</span>

                                    <span
                                        class="
                                            flex size-8 shrink-0 items-center justify-center
                                            rounded-full bg-rino-heading text-rino-background
                                        "
                                    >
                                        <svg
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            aria-hidden="true"
                                            class="size-4"
                                        >
                                            <path d="M4 10h12M11 5l5 5-5 5" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div
                            class="
                                pointer-events-none absolute inset-px
                                rounded-[var(--radius-card)] ring-1 ring-black/5
                            "
                        ></div>
                    </article>
                @endforeach
            </div>
        @else
            <div
                class="
                    flex w-full flex-wrap gap-4
                    {{ $isCentered ? 'justify-center' : 'justify-start' }}
                    xl:gap-5
                "
            >
                @foreach ($plans as $plan)
                    @php
                        $hasVisual =
                            ($plan['visual_type'] ?? 'none') === 'upload'
                            && filled($plan['image'] ?? null);

                        $image = $plan['image'] ?? null;

                        $specs = collect($plan['specs'] ?? [])
                            ->filter(fn ($spec) => filled($spec['label'] ?? null))
                            ->values();

                        $showClassicVisual = $cardStyle === 'classic' && $hasVisual;
                        $showRightVisual = $cardStyle === 'visual-right' && $hasVisual;
                        $showTopVisual = $cardStyle === 'visual-top' && $hasVisual;

                        $popular = (bool) ($plan['popular'] ?? false);

                        $recommended =
                            !$popular && (bool) ($plan['recommended'] ?? false);

                        $hasBadge = $popular || $recommended;
                    @endphp

                    <article
                        data-plan-card
                        data-plan-id="{{ $plan['id'] }}"
                        data-style="{{ $cardStyle }}"
                        class="
                            relative flex w-full min-w-0 flex-col overflow-hidden
                            rounded-[var(--radius-card)] bg-rino-surface
                            sm:w-[calc((100%-1rem)/2)]
                            lg:w-[calc((100%-2rem)/3)]
                            xl:w-[calc((100%-3.75rem)/4)]
                        "
                    >
                        @if ($hasBadge)
                            <div
                                aria-hidden="true"
                                class="
                                    pointer-events-none absolute right-0 top-0 z-20 size-24
                                    overflow-hidden
                                "
                            >
                                <span
                                    class="
                                        absolute flex h-6 items-center justify-center
                                        whitespace-nowrap bg-rino-primary text-center
                                        font-extrabold uppercase leading-none tracking-wide
                                        text-rino-primary-text

                                        {{ $popular
                                            ? '-right-[1.9rem] top-[1.05rem] w-28 rotate-45 text-[0.625rem]'
                                            : '-right-[2.55rem] top-[1.3rem] w-36 rotate-45 text-[0.55rem]'
                                        }}
                                    "
                                >
                                    {{ $popular ? 'Popular' : 'Recommended' }}
                                </span>
                            </div>
                        @endif

                        <div class="flex min-w-0 flex-1 flex-col p-4 sm:p-5">
                            @if ($showTopVisual)
                                <span
                                    class="
                                        mb-3 flex size-12 shrink-0 items-center justify-center
                                        overflow-hidden rounded-md
                                    "
                                >
                                    <img
                                        src="{{ \App\Support\AssetUrl::resolve($image) }}"
                                        alt=""
                                        class="size-full object-contain"
                                    >
                                </span>
                            @endif

                            @if ($cardStyle === 'visual-right')
                                <div
                                    class="
                                        grid min-w-0 grid-cols-[minmax(0,1fr)_auto]
                                        items-center gap-3
                                        {{ $hasBadge ? 'pr-10' : '' }}
                                    "
                                >
                                    <div class="min-w-0">
                                        <h3
                                            class="
                                                break-words text-base font-bold leading-snug
                                                text-rino-heading
                                            "
                                        >
                                            {{ $plan['name'] }}
                                        </h3>

                                        @if (filled($plan['description'] ?? null))
                                            <p
                                                class="
                                                    mt-1 text-sm leading-relaxed
                                                    text-rino-muted
                                                "
                                            >
                                                {{ $plan['description'] }}
                                            </p>
                                        @endif
                                    </div>

                                    @if ($showRightVisual)
                                        <span
                                            class="
                                                flex size-11 shrink-0 items-center justify-center
                                                overflow-hidden rounded-md sm:size-12
                                            "
                                        >
                                            <img
                                                src="{{ \App\Support\AssetUrl::resolve($image) }}"
                                                alt=""
                                                class="size-full object-contain"
                                            >
                                        </span>
                                    @endif
                                </div>
                            @elseif ($cardStyle === 'classic')
                                <div
                                    class="
                                        flex min-w-0 items-center gap-3
                                        {{ $hasBadge ? 'pr-10' : '' }}
                                    "
                                >
                                    @if ($showClassicVisual)
                                        <span
                                            class="
                                                flex size-11 shrink-0 items-center justify-center
                                                overflow-hidden rounded-md sm:size-12
                                            "
                                        >
                                            <img
                                                src="{{ \App\Support\AssetUrl::resolve($image) }}"
                                                alt=""
                                                class="size-full object-contain"
                                            >
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <h3
                                            class="
                                                break-words text-base font-bold leading-snug
                                                text-rino-heading
                                            "
                                        >
                                            {{ $plan['name'] }}
                                        </h3>

                                        @if (filled($plan['description'] ?? null))
                                            <p
                                                class="
                                                    mt-1 text-sm leading-relaxed
                                                    text-rino-muted
                                                "
                                            >
                                                {{ $plan['description'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div
                                    class="
                                        min-w-0
                                        {{ $hasBadge ? 'pr-10' : '' }}
                                    "
                                >
                                    <h3
                                        class="
                                            break-words text-base font-bold leading-snug
                                            text-rino-heading
                                        "
                                    >
                                        {{ $plan['name'] }}
                                    </h3>

                                    @if ($cardStyle !== 'minimal' && filled($plan['description'] ?? null))
                                        <p
                                            class="
                                                mt-1 text-sm leading-relaxed
                                                text-rino-muted
                                            "
                                        >
                                            {{ $plan['description'] }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-4 border-b border-rino-border pb-3">
                                <div class="flex flex-wrap items-end gap-x-1.5 gap-y-1">
                                    <span
                                        class="
                                            text-[1.65rem] font-bold leading-none
                                            tracking-tight text-rino-primary
                                        "
                                    >
                                        <span>{{ $currencySymbol }}</span><span data-plan-price>--</span>
                                    </span>

                                    <span
                                        data-plan-price-cycle
                                        class="
                                            pb-0.5 text-sm font-semibold leading-none
                                            text-rino-muted
                                        "
                                    ></span>
                                </div>

                                <span
                                    data-plan-discount
                                    class="
                                        mt-1 hidden text-xs font-bold leading-none
                                        text-rino-primary
                                    "
                                ></span>
                            </div>

                            @if ($specs->isNotEmpty())
                                <div class="mt-3 flex min-w-0 flex-col gap-2.5">
                                    @foreach ($specs as $spec)
                                        <div
                                            class="
                                                flex min-w-0 items-center gap-2.5 text-sm
                                                font-medium leading-snug text-rino-body
                                            "
                                        >
                                            <span
                                                class="
                                                    flex size-[1.125rem] shrink-0 items-center
                                                    justify-center text-rino-primary
                                                "
                                            >
                                                <x-sections.partials.plan-icon
                                                    :name="$spec['icon'] ?? 'check'"
                                                    class="size-full"
                                                />
                                            </span>

                                            <span class="min-w-0 break-words">
                                                {{ $spec['label'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-auto flex w-full justify-center pt-5">
                                <a
                                    data-plan-order
                                    href="#"
                                    class="
                                        inline-flex min-h-10 w-full items-center justify-between
                                        gap-3 rounded-[var(--radius-button)] bg-rino-primary
                                        py-1.5 pl-4 pr-1.5 text-sm font-bold
                                        text-rino-primary-text no-underline transition-opacity
                                        hover:opacity-90
                                        aria-disabled:pointer-events-none aria-disabled:opacity-40
                                        sm:w-52
                                        lg:w-full
                                        xl:w-52
                                    "
                                >
                                    <span data-plan-order-label>Order Now</span>

                                    <span
                                        class="
                                            flex size-7 shrink-0 items-center justify-center
                                            rounded-full bg-rino-heading text-rino-background
                                        "
                                    >
                                        <svg
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            aria-hidden="true"
                                            class="size-4"
                                        >
                                            <path d="M4 10h12M11 5l5 5-5 5" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div
                            class="
                                pointer-events-none absolute inset-px
                                rounded-[var(--radius-card)] ring-1 ring-black/5
                            "
                        ></div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        (() => {
            const root = document.getElementById(@js($plansId));

            if (!root) {
                return;
            }

            const cycles = @js($cyclePayload);
            const plans = @js($planPayload);
            const defaultCycleId = @js($defaultCycleId);
            const priceDisplay = @js($priceDisplay);
            const showCycleDiscount = @js($showCycleDiscount);
            const currencyRate = Number(@js($currencyRate));
            const currencyDecimals = Number(@js($currencyDecimals));

            const cycleMap = Object.fromEntries(
                cycles.map((cycle) => [String(cycle.id), cycle])
            );

            const planMap = Object.fromEntries(
                plans.map((plan) => [String(plan.id), plan])
            );

            let selectedCycleId = defaultCycleId
                ? String(defaultCycleId)
                : (cycles[0] ? String(cycles[0].id) : null);

            const money = (value) => {
                const number = Number(value);

                if (!Number.isFinite(number)) {
                    return '--';
                }

                return number.toLocaleString(undefined, {
                    minimumFractionDigits: currencyDecimals,
                    maximumFractionDigits: currencyDecimals,
                });
            };

            const convertPrice = (value) => {
                const number = Number(value);

                if (!Number.isFinite(number)) {
                    return null;
                }

                return number * currencyRate;
            };

            const monthlyEquivalent = (price, cycle) => {
                const months = Math.max(1, Number(cycle?.months || 1));

                return Number(price) / months;
            };

            const displayedPrice = (price, cycle) => {
                if (priceDisplay === 'monthly-equivalent') {
                    return monthlyEquivalent(price, cycle);
                }

                return Number(price);
            };

            const cycleSuffix = (cycle) => {
                if (priceDisplay === 'monthly-equivalent') {
                    return '/mo';
                }

                if (cycle?.short_label) {
                    return '/' + cycle.short_label;
                }

                const months = Math.max(1, Number(cycle?.months || 1));

                if (months === 1) {
                    return '/mo';
                }

                if (months === 12) {
                    return '/yr';
                }

                return '/' + String(cycle?.name || '').toLowerCase();
            };

            const savingsFor = (plan, selectedCycleId) => {
                if (!showCycleDiscount || !defaultCycleId) {
                    return null;
                }

                if (String(selectedCycleId) === String(defaultCycleId)) {
                    return null;
                }

                const selectedCycle = cycleMap[String(selectedCycleId)];
                const defaultCycle = cycleMap[String(defaultCycleId)];

                const selectedPrice =
                    plan.prices[String(selectedCycleId)]?.price;
                const defaultPrice =
                    plan.prices[String(defaultCycleId)]?.price;

                if (
                    !selectedCycle ||
                    !defaultCycle ||
                    !Number.isFinite(Number(selectedPrice)) ||
                    !Number.isFinite(Number(defaultPrice))
                ) {
                    return null;
                }

                const selectedMonths = Math.max(
                    1,
                    Number(selectedCycle.months || 1)
                );
                const defaultMonths = Math.max(
                    1,
                    Number(defaultCycle.months || 1)
                );

                const defaultMonthlyRate =
                    Number(defaultPrice) / defaultMonths;
                const expectedCost = defaultMonthlyRate * selectedMonths;
                const actualCost = Number(selectedPrice);

                if (expectedCost <= 0 || actualCost >= expectedCost) {
                    return null;
                }

                const percentage =
                    (1 - actualCost / expectedCost) * 100;

                if (percentage <= 0) {
                    return null;
                }

                return Math.round(percentage);
            };

            const updateCard = (card, cycleId) => {
                const plan = planMap[String(card.dataset.planId)];
                const cycle = cycleMap[String(cycleId)];

                if (!plan || !cycle) {
                    return;
                }

                const price = plan.prices[String(cycleId)];

                const priceNode = card.querySelector('[data-plan-price]');
                const cycleNode = card.querySelector('[data-plan-price-cycle]');
                const discountNode = card.querySelector('[data-plan-discount]');
                const orderNode = card.querySelector('[data-plan-order]');
                const orderLabelNode = card.querySelector('[data-plan-order-label]');

                if (!price) {
                    card.dataset.cycleAvailable = 'false';

                    if (priceNode) {
                        priceNode.textContent = '--';
                    }

                    if (cycleNode) {
                        cycleNode.textContent = '';
                    }

                    if (discountNode) {
                        discountNode.textContent = '';
                        discountNode.classList.add('hidden');
                    }

                    if (orderNode) {
                        orderNode.removeAttribute('href');
                        orderNode.setAttribute('aria-disabled', 'true');
                    }

                    if (orderLabelNode) {
                        orderLabelNode.textContent = 'Unavailable';
                    }

                    return;
                }

                card.dataset.cycleAvailable = 'true';

                const baseDisplayedPrice = displayedPrice(
                    Number(price.price),
                    cycle
                );
                const shownPrice = convertPrice(baseDisplayedPrice);

                if (priceNode) {
                    priceNode.textContent = money(shownPrice);
                }

                if (cycleNode) {
                    cycleNode.textContent = cycleSuffix(cycle);
                }

                const saving = savingsFor(plan, cycleId);

                if (discountNode && saving) {
                    discountNode.textContent = 'Save ' + saving + '%';
                    discountNode.classList.remove('hidden');
                } else if (discountNode) {
                    discountNode.textContent = '';
                    discountNode.classList.add('hidden');
                }

                const checkoutUrl = price.checkout_url;

                if (orderNode && checkoutUrl) {
                    orderNode.href = checkoutUrl;
                    orderNode.setAttribute('aria-disabled', 'false');
                } else if (orderNode) {
                    orderNode.removeAttribute('href');
                    orderNode.setAttribute('aria-disabled', 'true');
                }

                if (orderLabelNode) {
                    orderLabelNode.textContent = checkoutUrl
                        ? 'Order Now'
                        : 'Unavailable';
                }
            };

            const updateSelectorButtons = (selector, cycleId) => {
                if (!selector) {
                    return;
                }

                selector
                    .querySelectorAll(
                        '[data-group-type="billing"] [data-selector-option]'
                    )
                    .forEach((button) => {
                        const active =
                            String(button.dataset.optionId) === String(cycleId);

                        button.dataset.selected = active ? 'true' : 'false';
                        button.setAttribute('aria-pressed', active ? 'true' : 'false');
                        button.style.background = active
                            ? 'var(--primary)'
                            : 'transparent';
                        button.style.color = active
                            ? 'var(--primary-text)'
                            : 'var(--text-body)';
                    });

                selector
                    .querySelectorAll('[data-group-type="billing"]')
                    .forEach((group) => {
                        group.dataset.selectedOption = String(cycleId);
                    });
            };

            const updateFallbackButtons = (cycleId) => {
                root.querySelectorAll('[data-plans-cycle]').forEach((button) => {
                    button.dataset.selected =
                        String(button.dataset.cycleId) === String(cycleId)
                            ? 'true'
                            : 'false';
                });
            };

            const setCycle = (cycleId, selector = null) => {
                const normalized = String(cycleId);

                if (!cycleMap[normalized]) {
                    return;
                }

                selectedCycleId = normalized;

                root.querySelectorAll('[data-plan-card]').forEach((card) => {
                    updateCard(card, normalized);
                });

                updateSelectorButtons(selector, normalized);
                updateFallbackButtons(normalized);
            };

            const findNearestPreviousSelector = () => {
                const selectors = Array.from(
                    document.querySelectorAll('[data-rino-selector]')
                );

                let nearest = null;

                selectors.forEach((selector) => {
                    const position = selector.compareDocumentPosition(root);

                    if (position & Node.DOCUMENT_POSITION_FOLLOWING) {
                        nearest = selector;
                    }
                });

                return nearest;
            };

            const createBillingButtons = (selector) => {
                if (!selector || !cycles.length) {
                    return false;
                }

                const groups = selector.querySelectorAll(
                    '[data-selector-group][data-group-type="billing"]'
                );

                if (!groups.length) {
                    return false;
                }

                groups.forEach((group) => {
                    let shell = group.querySelector('[data-billing-options]');

                    if (!shell) {
                        shell = document.createElement('div');
                        shell.dataset.billingOptions = '';
                        shell.className = [
                            'inline-flex',
                            'max-w-full',
                            'items-center',
                            'gap-1',
                            'overflow-x-auto',
                            'rounded-full',
                            'border',
                            'border-rino-border',
                            'bg-rino-surface',
                            'p-1',
                        ].join(' ');
                        group.appendChild(shell);
                    }

                    shell.innerHTML = '';

                    if (cycles.length <= 1) {
                        group.hidden = true;
                        return;
                    }

                    group.hidden = false;

                    cycles.forEach((cycle) => {
                        const button = document.createElement('button');

                        button.type = 'button';

                        button.className = [
                            'inline-flex',
                            'min-h-10',
                            'shrink-0',
                            'items-center',
                            'justify-center',
                            'rounded-full',
                            'px-4',
                            'text-sm',
                            'font-semibold',
                            'transition',
                        ].join(' ');

                        button.dataset.selectorOption = '';
                        button.dataset.optionId = String(cycle.id);

                        const active =
                            String(cycle.id) === String(selectedCycleId);

                        button.dataset.selected = active ? 'true' : 'false';
                        button.setAttribute('aria-pressed', active ? 'true' : 'false');
                        button.style.background = active
                            ? 'var(--primary)'
                            : 'transparent';
                        button.style.color = active
                            ? 'var(--primary-text)'
                            : 'var(--text-body)';
                        button.textContent = cycle.name;

                        button.addEventListener('click', () => {
                            selector.dispatchEvent(
                                new CustomEvent('rino:selector-change', {
                                    bubbles: true,
                                    detail: {
                                        selectorId: selector.id,
                                        groupId: group.dataset.groupId,
                                        groupType: 'billing',
                                        optionId: String(cycle.id),
                                    },
                                })
                            );
                        });

                        shell.appendChild(button);
                    });

                    group.dataset.selectedOption = String(selectedCycleId);
                });

                return cycles.length > 1;
            };

            const selector = findNearestPreviousSelector();

            const selectedFilters = {};

            const syncSelectedFilters = () => {
                if (!selector) {
                    return;
                }

                selector
                    .querySelectorAll(
                        '[data-selector-group][data-group-type="normal"]'
                    )
                    .forEach((group) => {
                        const groupId =
                            group.dataset.groupId;

                        const optionId =
                            group.dataset.selectedOption;

                        if (
                            groupId
                            &&
                            optionId
                        ) {
                            selectedFilters[
                                String(groupId)
                            ] =
                                String(optionId);
                        }
                    });
            };

            const planMatchesFilters = (plan) => {
                const matches =
                    Array.isArray(
                        plan?.selector_matches
                    )
                        ? plan.selector_matches
                        : [];

                if (!matches.length) {
                    return true;
                }

                const grouped = {};

                matches.forEach((match) => {
                    const parts =
                        String(match)
                            .split('::');

                    if (parts.length !== 2) {
                        return;
                    }

                    const groupId =
                        parts[0];

                    const optionId =
                        parts[1];

                    if (
                        !groupId
                        ||
                        !optionId
                    ) {
                        return;
                    }

                    if (!grouped[groupId]) {
                        grouped[groupId] = [];
                    }

                    grouped[groupId].push(
                        optionId
                    );
                });

                return Object.entries(
                    grouped
                ).every(
                    ([groupId, optionIds]) => {
                        if (
                            !Object.prototype
                                .hasOwnProperty
                                .call(
                                    selectedFilters,
                                    groupId
                                )
                        ) {
                            return true;
                        }

                        const selectedOption = String(
                            selectedFilters[groupId]
                            ?? ''
                        );

                        const isAllOption =
                            selectedOption === 'all'
                            ||
                            selectedOption.endsWith('-all');

                        if (isAllOption) {
                            return true;
                        }

                        return optionIds.includes(
                            selectedOption
                        );
                    }
                );
            };

            const applyPlanFilters = () => {
                root
                    .querySelectorAll(
                        '[data-plan-card]'
                    )
                    .forEach((card) => {
                        const plan =
                            planMap[
                                String(
                                    card.dataset.planId
                                )
                            ];

                        const visible =
                            planMatchesFilters(
                                plan
                            );

                        card.hidden =
                            !visible;

                        card.style.display =
                            visible
                                ? ''
                                : 'none';
                    });
            };

            syncSelectedFilters();
            applyPlanFilters();

            const handleSelectorChange = (event) => {
                const detail =
                    event.detail
                    ?? {};

                if (
                    !selector
                    ||
                    event.target !== selector
                    ||
                    (
                        detail.selectorId
                        &&
                        String(detail.selectorId) !== String(selector.id)
                    )
                ) {
                    return;
                }

                if (
                    detail.groupType
                    ===
                    'billing'
                ) {
                    if (!detail.optionId) {
                        return;
                    }

                    setCycle(
                        detail.optionId,
                        selector
                    );

                    return;
                }

                if (
                    detail.groupType
                    !==
                    'normal'
                    ||
                    !detail.groupId
                    ||
                    !detail.optionId
                ) {
                    return;
                }

                selectedFilters[
                    String(
                        detail.groupId
                    )
                ] =
                    String(
                        detail.optionId
                    );

                applyPlanFilters();
            };

            document.addEventListener(
                'rino:selector-change',
                handleSelectorChange
            );

            const hasSelectorBilling = createBillingButtons(selector);

            const fallback = root.querySelector(
                '[data-plans-fallback-billing]'
            );

            if (fallback && !hasSelectorBilling && cycles.length > 1) {
                fallback.dataset.visible = 'true';
            }

            root.querySelectorAll('[data-plans-cycle]').forEach((button) => {
                button.addEventListener('click', () => {
                    setCycle(button.dataset.cycleId, selector);
                });
            });

            if (selectedCycleId) {
                setCycle(selectedCycleId, selector);
            }
        })();
    </script>
</section>
