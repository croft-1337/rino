<?php

namespace App\Support\Currency;

class CurrencyRegistry
{
    public static function all(): array
    {
        return [
            'USD' => [
                'name' => 'US Dollar',
                'symbol' => '$',
                'flag' => 'us',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'EUR' => [
                'name' => 'Euro',
                'symbol' => '€',
                'flag' => 'eu',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'GBP' => [
                'name' => 'British Pound',
                'symbol' => '£',
                'flag' => 'gb',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'CAD' => [
                'name' => 'Canadian Dollar',
                'symbol' => 'C$',
                'flag' => 'ca',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'AUD' => [
                'name' => 'Australian Dollar',
                'symbol' => 'A$',
                'flag' => 'au',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'SGD' => [
                'name' => 'Singapore Dollar',
                'symbol' => 'S$',
                'flag' => 'sg',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'PKR' => [
                'name' => 'Pakistani Rupee',
                'symbol' => 'Rs',
                'flag' => 'pk',
                'decimals' => 0,
                'symbol_position' => 'before',
            ],

            'AED' => [
                'name' => 'UAE Dirham',
                'symbol' => 'AED',
                'flag' => 'ae',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'SAR' => [
                'name' => 'Saudi Riyal',
                'symbol' => 'SAR',
                'flag' => 'sa',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'JPY' => [
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'flag' => 'jp',
                'decimals' => 0,
                'symbol_position' => 'before',
            ],

            'CNY' => [
                'name' => 'Chinese Yuan',
                'symbol' => '¥',
                'flag' => 'cn',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'INR' => [
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'flag' => 'in',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'CHF' => [
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'flag' => 'ch',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],

            'NZD' => [
                'name' => 'New Zealand Dollar',
                'symbol' => 'NZ$',
                'flag' => 'nz',
                'decimals' => 2,
                'symbol_position' => 'before',
            ],
        ];
    }

    public static function get(string $currency): ?array
    {
        return self::all()[
            strtoupper($currency)
        ] ?? null;
    }

    public static function exists(string $currency): bool
    {
        return array_key_exists(
            strtoupper($currency),
            self::all()
        );
    }

    public static function name(string $currency): string
    {
        return self::get($currency)['name']
            ?? strtoupper($currency);
    }

    public static function symbol(string $currency): string
    {
        return self::get($currency)['symbol']
            ?? strtoupper($currency);
    }

    public static function decimals(string $currency): int
    {
        return (int) (
            self::get($currency)['decimals']
            ?? 2
        );
    }

    public static function flagCode(string $currency): ?string
    {
        return self::get($currency)['flag']
            ?? null;
    }

    public static function flag(string $currency): ?string
    {
        $code = self::flagCode($currency);

        if (!$code) {
            return null;
        }

        return '/assets/flags/'
            . $code
            . '.png';
    }

    public static function options(): array
    {
        return collect(
            self::all()
        )
            ->mapWithKeys(
                fn (
                    array $data,
                    string $currency
                ): array => [
                    $currency =>
                        $currency
                        . ' — '
                        . $data['name'],
                ]
            )
            ->all();
    }

    public static function codes(): array
    {
        return array_keys(
            self::all()
        );
    }
}
