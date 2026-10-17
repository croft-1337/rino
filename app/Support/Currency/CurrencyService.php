<?php

namespace App\Support\Currency;

use App\Models\Setting;

class CurrencyService
{
    protected ?array $settings = null;

    public function base(): string
    {
        $currency =
            strtoupper(
                (string) $this->setting(
                    'default_currency',
                    'USD'
                )
            );

        return CurrencyRegistry::exists(
            $currency
        )
            ? $currency
            : 'USD';
    }

    public function enabled(): array
    {
        $currencies =
            json_decode(
                (string) $this->setting(
                    'enabled_currencies',
                    '["USD"]'
                ),
                true
            );

        if (
            !is_array(
                $currencies
            )
        ) {
            $currencies = [];
        }

        $currencies =
            collect(
                $currencies
            )
                ->map(
                    fn ($currency): string =>
                        strtoupper(
                            trim(
                                (string) $currency
                            )
                        )
                )
                ->filter(
                    fn (string $currency): bool =>
                        CurrencyRegistry::exists(
                            $currency
                        )
                )
                ->unique()
                ->values()
                ->all();

        $base =
            $this->base();

        if (
            !in_array(
                $base,
                $currencies,
                true
            )
        ) {
            array_unshift(
                $currencies,
                $base
            );
        }

        return $currencies;
    }

    public function selected(): string
    {
        $selected =
            strtoupper(
                (string) session(
                    'currency',
                    $this->base()
                )
            );

        if (
            !in_array(
                $selected,
                $this->enabled(),
                true
            )
        ) {
            $selected =
                $this->base();

            session([
                'currency' =>
                    $selected,
            ]);
        }

        return $selected;
    }

    public function rateMode(): string
    {
        $mode =
            (string) $this->setting(
                'currency_rate_mode',
                'automatic'
            );

        return $mode ===
            'manual'
                ? 'manual'
                : 'automatic';
    }

    public function isAutomatic(): bool
    {
        return $this->rateMode()
            ===
            'automatic';
    }

    public function isManual(): bool
    {
        return $this->rateMode()
            ===
            'manual';
    }

    public function rates(): array
    {
        $key =
            $this->isManual()
                ? 'currency_manual_rates'
                : 'currency_rates';

        $rates =
            json_decode(
                (string) $this->setting(
                    $key,
                    '{}'
                ),
                true
            );

        if (
            !is_array(
                $rates
            )
        ) {
            $rates = [];
        }

        $normalized = [];

        foreach (
            $rates
            as $currency => $rate
        ) {
            $currency =
                strtoupper(
                    (string) $currency
                );

            if (
                !CurrencyRegistry::exists(
                    $currency
                )
                ||
                !in_array(
                    $currency,
                    $this->enabled(),
                    true
                )
                ||
                !is_numeric(
                    $rate
                )
                ||
                (float) $rate <= 0
            ) {
                continue;
            }

            $normalized[
                $currency
            ] =
                (float) $rate;
        }

        $normalized[
            $this->base()
        ] = 1.0;

        return $normalized;
    }

    public function rate(
        ?string $currency = null
    ): ?float {
        $currency =
            strtoupper(
                $currency
                ?: $this->selected()
            );

        if (
            $currency ===
            $this->base()
        ) {
            return 1.0;
        }

        return $this->rates()[
            $currency
        ]
            ?? null;
    }

    public function canConvert(
        ?string $currency = null
    ): bool {
        return $this->rate(
            $currency
        ) !== null;
    }

    public function convert(
        float|int|string $amount,
        ?string $currency = null
    ): float {
        $amount =
            (float) $amount;

        $currency =
            strtoupper(
                $currency
                ?: $this->selected()
            );

        $rate =
            $this->rate(
                $currency
            );

        if (
            $rate === null
        ) {
            return $amount;
        }

        return $amount
            *
            $rate;
    }

    public function symbol(
        ?string $currency = null
    ): string {
        return CurrencyRegistry::symbol(
            $currency
            ?: $this->selected()
        );
    }

    public function name(
        ?string $currency = null
    ): string {
        return CurrencyRegistry::name(
            $currency
            ?: $this->selected()
        );
    }

    public function flag(
        ?string $currency = null
    ): ?string {
        return CurrencyRegistry::flag(
            $currency
            ?: $this->selected()
        );
    }

    public function decimals(
        ?string $currency = null
    ): int {
        return CurrencyRegistry::decimals(
            $currency
            ?: $this->selected()
        );
    }

    public function formatNumber(
        float|int|string $amount,
        ?string $currency = null
    ): string {
        $currency =
            strtoupper(
                $currency
                ?: $this->selected()
            );

        return number_format(
            (float) $amount,
            $this->decimals(
                $currency
            ),
            '.',
            ','
        );
    }

    public function format(
        float|int|string $amount,
        ?string $currency = null,
        bool $convert = true
    ): string {
        $currency =
            strtoupper(
                $currency
                ?: $this->selected()
            );

        $value =
            $convert
                ? $this->convert(
                    $amount,
                    $currency
                )
                : (float) $amount;

        return $this->symbol(
            $currency
        )
            .
            $this->formatNumber(
                $value,
                $currency
            );
    }

    public function metadata(
        ?string $currency = null
    ): array {
        $currency =
            strtoupper(
                $currency
                ?: $this->selected()
            );

        return [
            'code' =>
                $currency,

            'name' =>
                $this->name(
                    $currency
                ),

            'symbol' =>
                $this->symbol(
                    $currency
                ),

            'flag' =>
                $this->flag(
                    $currency
                ),

            'decimals' =>
                $this->decimals(
                    $currency
                ),

            'rate' =>
                $this->rate(
                    $currency
                ),
        ];
    }

    public function frontend(): array
    {
        $currencies = [];

        foreach (
            $this->enabled()
            as $currency
        ) {
            $currencies[
                $currency
            ] =
                $this->metadata(
                    $currency
                );
        }

        return [
            'base' =>
                $this->base(),

            'selected' =>
                $this->selected(),

            'enabled' =>
                $this->enabled(),

            'mode' =>
                $this->rateMode(),

            'currencies' =>
                $currencies,

            'rates' =>
                $this->rates(),

            'updated_at' =>
                $this->setting(
                    'currency_rates_updated_at'
                ),
        ];
    }

    protected function setting(
        string $key,
        mixed $default = null
    ): mixed {
        if (
            $this->settings === null
        ) {
            $this->settings =
                Setting::query()
                    ->pluck(
                        'value',
                        'key'
                    )
                    ->all();
        }

        return $this->settings[
            $key
        ]
            ?? $default;
    }
}