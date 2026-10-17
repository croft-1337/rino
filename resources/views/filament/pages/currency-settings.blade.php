<x-filament-panels::page>
    @php
        $status =
            $this->getRateStatus();

        $rateMode =
            strtolower(
                (string) (
                    $status['mode']
                    ?? 'automatic'
                )
            );

        $isAutomatic =
            $rateMode === 'automatic';

        $baseCurrency =
            strtoupper(
                (string) (
                    $status['base']
                    ?? 'USD'
                )
            );

        $provider =
            $status['provider']
            ?? 'Frankfurter';

        $updatedAt =
            $status['updated_at']
            ?? null;

        $providerDate =
            $status['provider_date']
            ?? null;

        $rates =
            $status['rates']
            ?? [];
    @endphp

    <div
        class="
            grid
            gap-6
            xl:grid-cols-[minmax(0,1fr)_380px]
        "
    >
        <div>
            {{ $this->form }}
        </div>

        <div class="space-y-6">

            <x-filament::section>
                <x-slot name="heading">
                    Exchange Rate Status
                </x-slot>

                <div class="rino-currency-status">
                    <div class="rino-status-row">
                        <span class="rino-status-label">
                            Mode
                        </span>

                        <span
                            class="
                                rino-status-badge
                                {{ $isAutomatic
                                    ? 'is-success'
                                    : 'is-warning'
                                }}
                            "
                        >
                            <span
                                class="rino-status-dot"
                            ></span>

                            {{ ucfirst($rateMode) }}
                        </span>
                    </div>

                    <div class="rino-status-row">
                        <span class="rino-status-label">
                            Base Currency
                        </span>

                        <strong class="rino-status-value">
                            {{ $baseCurrency }}
                        </strong>
                    </div>

                    <div class="rino-status-row">
                        <span class="rino-status-label">
                            Provider
                        </span>

                        <span class="rino-status-value">
                            {{ $provider }}
                        </span>
                    </div>

                    <div class="rino-status-row">
                        <span class="rino-status-label">
                            Last Refresh
                        </span>

                        <span class="rino-status-value">
                            {{ $updatedAt ?: 'Never' }}
                        </span>
                    </div>

                    @if ($providerDate)
                        <div class="rino-status-row">
                            <span class="rino-status-label">
                                Provider Date
                            </span>

                            <span class="rino-status-value">
                                {{ $providerDate }}
                            </span>
                        </div>
                    @endif
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    Active Rates
                </x-slot>

                <x-slot name="description">
                    {{ count($rates) }}
                    {{ count($rates) === 1
                        ? 'currency'
                        : 'currencies'
                    }}
                    active
                </x-slot>

                @if (!empty($rates))
                    <div class="rino-rates-table">
                        <div class="rino-rates-head">
                            <span>
                                Currency
                            </span>

                            <span>
                                Rate
                            </span>
                        </div>

                        @foreach (
                            $rates
                            as $currency => $rate
                        )
                            @php
                                $currency =
                                    strtoupper(
                                        (string) $currency
                                    );

                                $formattedRate =
                                    rtrim(
                                        rtrim(
                                            number_format(
                                                (float) $rate,
                                                6,
                                                '.',
                                                ''
                                            ),
                                            '0'
                                        ),
                                        '.'
                                    );
                            @endphp

                            <div
                                class="
                                    rino-rate-row
                                    {{ $currency === $baseCurrency
                                        ? 'is-base'
                                        : ''
                                    }}
                                "
                            >
                                <div
                                    class="rino-rate-currency"
                                >
                                    <span
                                        class="
                                            rino-rate-code
                                        "
                                    >
                                        {{ $currency }}
                                    </span>

                                    @if (
                                        $currency ===
                                        $baseCurrency
                                    )
                                        <span
                                            class="
                                                rino-base-badge
                                            "
                                        >
                                            Base
                                        </span>
                                    @endif
                                </div>

                                <span
                                    class="rino-rate-value"
                                >
                                    {{ $formattedRate }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rino-empty-rates">
                        No exchange rates are currently available.
                    </div>
                @endif
            </x-filament::section>

        </div>
    </div>

    <style>
        .rino-currency-status {
            display: flex;
            flex-direction: column;
        }

        .rino-status-row {
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                auto;
            align-items: center;
            gap: 1rem;
            min-height: 3rem;
            padding: 0.7rem 0;
            border-bottom:
                1px solid
                color-mix(
                    in srgb,
                    currentColor 9%,
                    transparent
                );
        }

        .rino-status-row:first-child {
            padding-top: 0;
        }

        .rino-status-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .rino-status-label {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.62;
        }

        .rino-status-value {
            max-width: 12rem;
            overflow-wrap: anywhere;
            text-align: right;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .rino-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            width: fit-content;
            padding: 0.3rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .rino-status-badge.is-success {
            color: rgb(34 197 94);
            background:
                color-mix(
                    in srgb,
                    rgb(34 197 94) 12%,
                    transparent
                );
        }

        .rino-status-badge.is-warning {
            color: rgb(245 158 11);
            background:
                color-mix(
                    in srgb,
                    rgb(245 158 11) 12%,
                    transparent
                );
        }

        .rino-status-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 9999px;
            background: currentColor;
        }

        .rino-rates-table {
            overflow: hidden;
            border:
                1px solid
                color-mix(
                    in srgb,
                    currentColor 9%,
                    transparent
                );
            border-radius: 0.75rem;
        }

        .rino-rates-head,
        .rino-rate-row {
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                auto;
            align-items: center;
            gap: 1rem;
        }

        .rino-rates-head {
            padding:
                0.65rem
                0.9rem;
            background:
                color-mix(
                    in srgb,
                    currentColor 4%,
                    transparent
                );
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            opacity: 0.62;
        }

        .rino-rates-head > :last-child {
            text-align: right;
        }

        .rino-rate-row {
            min-height: 3rem;
            padding:
                0.65rem
                0.9rem;
            border-top:
                1px solid
                color-mix(
                    in srgb,
                    currentColor 8%,
                    transparent
                );
        }

        .rino-rate-row.is-base {
            background:
                color-mix(
                    in srgb,
                    rgb(245 158 11) 5%,
                    transparent
                );
        }

        .rino-rate-currency {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            min-width: 0;
        }

        .rino-rate-code {
            font-size: 0.875rem;
            font-weight: 700;
        }

        .rino-rate-value {
            text-align: right;
            font-family:
                ui-monospace,
                SFMono-Regular,
                Menlo,
                Monaco,
                Consolas,
                monospace;
            font-size: 0.825rem;
            font-weight: 600;
            font-variant-numeric:
                tabular-nums;
        }

        .rino-base-badge {
            display: inline-flex;
            align-items: center;
            padding:
                0.18rem
                0.42rem;
            border-radius: 9999px;
            color: rgb(245 158 11);
            background:
                color-mix(
                    in srgb,
                    rgb(245 158 11) 12%,
                    transparent
                );
            font-size: 0.625rem;
            font-weight: 700;
            line-height: 1;
            text-transform: uppercase;
        }

        .rino-empty-rates {
            padding: 1rem;
            border:
                1px dashed
                color-mix(
                    in srgb,
                    currentColor 12%,
                    transparent
                );
            border-radius: 0.75rem;
            text-align: center;
            font-size: 0.875rem;
            opacity: 0.6;
        }

        @media (max-width: 640px) {
            .rino-status-row {
                grid-template-columns: 1fr;
                gap: 0.3rem;
            }

            .rino-status-value {
                max-width: none;
                text-align: left;
            }
        }
    </style>
</x-filament-panels::page>