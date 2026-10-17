<?php

namespace App\Support;

class LocationPresets
{
    public const MAP_WIDTH = 126;

    public const MAP_HEIGHT = 60;

    public static function all(): array
    {
        return [
            'new-york' => [
                'city' => 'New York',
                'country' => 'United States',
                'country_code' => 'us',
                'region' => 'North America',
                'x' => 37,
                'y' => 19,
            ],

            'los-angeles' => [
                'city' => 'Los Angeles',
                'country' => 'United States',
                'country_code' => 'us',
                'region' => 'North America',
                'x' => 22,
                'y' => 22,
            ],

            'dallas' => [
                'city' => 'Dallas',
                'country' => 'United States',
                'country_code' => 'us',
                'region' => 'North America',
                'x' => 29,
                'y' => 23,
            ],

            'miami' => [
                'city' => 'Miami',
                'country' => 'United States',
                'country_code' => 'us',
                'region' => 'North America',
                'x' => 34,
                'y' => 26,
            ],

            'chicago' => [
                'city' => 'Chicago',
                'country' => 'United States',
                'country_code' => 'us',
                'region' => 'North America',
                'x' => 32,
                'y' => 19,
            ],

            'toronto' => [
                'city' => 'Toronto',
                'country' => 'Canada',
                'country_code' => 'ca',
                'region' => 'North America',
                'x' => 35,
                'y' => 19,
            ],

            'london' => [
                'city' => 'London',
                'country' => 'United Kingdom',
                'country_code' => 'gb',
                'region' => 'Europe',
                'x' => 63,
                'y' => 15,
            ],

            'amsterdam' => [
                'city' => 'Amsterdam',
                'country' => 'Netherlands',
                'country_code' => 'nl',
                'region' => 'Europe',
                'x' => 65,
                'y' => 15,
            ],

            'frankfurt' => [
                'city' => 'Frankfurt',
                'country' => 'Germany',
                'country_code' => 'de',
                'region' => 'Europe',
                'x' => 66,
                'y' => 16,
            ],

            'paris' => [
                'city' => 'Paris',
                'country' => 'France',
                'country_code' => 'fr',
                'region' => 'Europe',
                'x' => 64,
                'y' => 17,
            ],

            'warsaw' => [
                'city' => 'Warsaw',
                'country' => 'Poland',
                'country_code' => 'pl',
                'region' => 'Europe',
                'x' => 70,
                'y' => 15,
            ],

            'dubai' => [
                'city' => 'Dubai',
                'country' => 'United Arab Emirates',
                'country_code' => 'ae',
                'region' => 'Middle East',
                'x' => 82,
                'y' => 26,
            ],

            'mumbai' => [
                'city' => 'Mumbai',
                'country' => 'India',
                'country_code' => 'in',
                'region' => 'Asia',
                'x' => 89,
                'y' => 28,
            ],

            'singapore' => [
                'city' => 'Singapore',
                'country' => 'Singapore',
                'country_code' => 'sg',
                'region' => 'Asia',
                'x' => 99,
                'y' => 35,
            ],

            'hong-kong' => [
                'city' => 'Hong Kong',
                'country' => 'Hong Kong',
                'country_code' => 'hk',
                'region' => 'Asia',
                'x' => 103,
                'y' => 27,
            ],

            'seoul' => [
                'city' => 'Seoul',
                'country' => 'South Korea',
                'country_code' => 'kr',
                'region' => 'Asia',
                'x' => 107,
                'y' => 20,
            ],

            'tokyo' => [
                'city' => 'Tokyo',
                'country' => 'Japan',
                'country_code' => 'jp',
                'region' => 'Asia',
                'x' => 112,
                'y' => 22,
            ],

            'sydney' => [
                'city' => 'Sydney',
                'country' => 'Australia',
                'country_code' => 'au',
                'region' => 'Oceania',
                'x' => 115,
                'y' => 50,
            ],

            'sao-paulo' => [
                'city' => 'São Paulo',
                'country' => 'Brazil',
                'country_code' => 'br',
                'region' => 'South America',
                'x' => 46,
                'y' => 45,
            ],

            'johannesburg' => [
                'city' => 'Johannesburg',
                'country' => 'South Africa',
                'country_code' => 'za',
                'region' => 'Africa',
                'x' => 73,
                'y' => 46,
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    public static function exists(string $key): bool
    {
        return array_key_exists(
            $key,
            self::all()
        );
    }

    public static function label(string $key): ?string
    {
        $location =
            self::get($key);

        if (!$location) {
            return null;
        }

        return $location['city']
            . ', '
            . $location['country'];
    }

    public static function options(): array
    {
        $options = [];

        foreach (
            self::all()
            as $key => $location
        ) {
            $options[$key] =
                $location['city']
                . ', '
                . $location['country'];
        }

        return $options;
    }

    public static function groupedOptions(): array
    {
        $groups = [];

        foreach (
            self::all()
            as $key => $location
        ) {
            $region =
                $location['region']
                ?? 'Other';

            $groups[$region][$key] =
                $location['city']
                . ', '
                . $location['country'];
        }

        return $groups;
    }

    public static function city(string $key): ?string
    {
        return self::get($key)['city']
            ?? null;
    }

    public static function country(string $key): ?string
    {
        return self::get($key)['country']
            ?? null;
    }

    public static function countryCode(string $key): ?string
    {
        return self::get($key)['country_code']
            ?? null;
    }

    public static function region(string $key): ?string
    {
        return self::get($key)['region']
            ?? null;
    }

    public static function coordinates(string $key): ?array
    {
        $location =
            self::get($key);

        if (!$location) {
            return null;
        }

        return [
            'x' => $location['x'],
            'y' => $location['y'],
        ];
    }

    public static function flag(string $key): ?string
    {
        $countryCode =
            self::countryCode($key);

        if (!$countryCode) {
            return null;
        }

        return '/assets/flags/'
            . $countryCode
            . '.png';
    }

    public static function count(): int
    {
        return count(
            self::all()
        );
    }
}
