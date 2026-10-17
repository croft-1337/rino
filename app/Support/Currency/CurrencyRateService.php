<?php

namespace App\Support\Currency;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CurrencyRateService
{
    public function __construct(
        protected CurrencyService $currency
    ) {
    }

    public function refresh(): array
    {
        $base =
            $this->currency->base();

        $enabled =
            $this->currency->enabled();

        $targets =
            collect($enabled)
                ->reject(
                    fn (string $currency): bool =>
                        $currency === $base
                )
                ->values()
                ->all();

        $rates = [
            $base => 1.0,
        ];

        if (empty($targets)) {
            $this->store(
                $rates,
                now()->toDateString()
            );

            return $rates;
        }

        $response =
            Http::acceptJson()
                ->timeout(15)
                ->retry(
                    2,
                    500
                )
                ->get(
                    'https://api.frankfurter.dev/v2/rates',
                    [
                        'base' =>
                            strtolower($base),

                        'quotes' =>
                            strtolower(
                                implode(
                                    ',',
                                    $targets
                                )
                            ),
                    ]
                );

        if (!$response->successful()) {
            throw new RuntimeException(
                'Currency rate provider returned HTTP '
                . $response->status()
                . '.'
            );
        }

        $payload =
            $response->json();

        if (!is_array($payload)) {
            throw new RuntimeException(
                'Currency rate provider returned an invalid response.'
            );
        }

        $latestDate = null;

        foreach ($payload as $row) {
            if (!is_array($row)) {
                continue;
            }

            $quote =
                strtoupper(
                    (string) (
                        $row['quote']
                        ?? ''
                    )
                );

            $rate =
                $row['rate']
                ?? null;

            if (
                !in_array(
                    $quote,
                    $targets,
                    true
                )
                ||
                !is_numeric($rate)
                ||
                (float) $rate <= 0
            ) {
                continue;
            }

            $rates[$quote] =
                (float) $rate;

            $date =
                $row['date']
                ?? null;

            if (
                is_string($date)
                &&
                (
                    $latestDate === null
                    ||
                    $date > $latestDate
                )
            ) {
                $latestDate = $date;
            }
        }

        $missing =
            collect($targets)
                ->reject(
                    fn (string $currency): bool =>
                        array_key_exists(
                            $currency,
                            $rates
                        )
                )
                ->values()
                ->all();

        if (!empty($missing)) {
            throw new RuntimeException(
                'No exchange rate returned for: '
                . implode(
                    ', ',
                    $missing
                )
                . '.'
            );
        }

        $this->store(
            $rates,
            $latestDate
                ?: now()->toDateString()
        );

        return $rates;
    }

    protected function store(
        array $rates,
        string $providerDate
    ): void {
        Setting::updateOrCreate(
            [
                'key' =>
                    'currency_rates',
            ],
            [
                'value' =>
                    json_encode(
                        $rates,
                        JSON_UNESCAPED_SLASHES
                        |
                        JSON_UNESCAPED_UNICODE
                    ),

                'type' =>
                    'textarea',

                'group' =>
                    'currency',
            ]
        );

        Setting::updateOrCreate(
            [
                'key' =>
                    'currency_rates_updated_at',
            ],
            [
                'value' =>
                    now()->toIso8601String(),

                'type' =>
                    'text',

                'group' =>
                    'currency',
            ]
        );

        Setting::updateOrCreate(
            [
                'key' =>
                    'currency_rates_provider_date',
            ],
            [
                'value' =>
                    $providerDate,

                'type' =>
                    'text',

                'group' =>
                    'currency',
            ]
        );

        Setting::updateOrCreate(
            [
                'key' =>
                    'currency_rates_provider',
            ],
            [
                'value' =>
                    'frankfurter',

                'type' =>
                    'text',

                'group' =>
                    'currency',
            ]
        );
    }
}