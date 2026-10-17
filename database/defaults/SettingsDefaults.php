<?php

namespace App\Support\Defaults;

use App\Models\Setting;
use RuntimeException;

class SettingsDefaults
{
    /**
     * Seed settings that do not exist yet.
     * Existing administrator values are preserved.
     */
    public static function seed(): void
    {
        foreach (
            self::all()
            as $key => $definition
        ) {
            if (
                !is_string($key)
                ||
                $key === ''
                ||
                !is_array($definition)
            ) {
                continue;
            }

            Setting::query()
                ->firstOrCreate(
                    [
                        'key' =>
                            $key,
                    ],
                    [
                        'value' =>
                            (string) (
                                $definition['value']
                                ?? ''
                            ),

                        'type' =>
                            (string) (
                                $definition['type']
                                ?? 'text'
                            ),

                        'group' =>
                            (string) (
                                $definition['group']
                                ?? 'general'
                            ),
                    ]
                );
        }
    }

    /**
     * Restore every default setting.
     * Existing values are intentionally overwritten.
     */
    public static function reset(): void
    {
        foreach (
            self::all()
            as $key => $definition
        ) {
            if (
                !is_string($key)
                ||
                $key === ''
                ||
                !is_array($definition)
            ) {
                continue;
            }

            Setting::query()
                ->updateOrCreate(
                    [
                        'key' =>
                            $key,
                    ],
                    [
                        'value' =>
                            (string) (
                                $definition['value']
                                ?? ''
                            ),

                        'type' =>
                            (string) (
                                $definition['type']
                                ?? 'text'
                            ),

                        'group' =>
                            (string) (
                                $definition['group']
                                ?? 'general'
                            ),
                    ]
                );
        }
    }

    public static function all(): array
    {
        $file =
            database_path(
                'defaults/settings.php'
            );

        if (!is_file($file)) {
            throw new RuntimeException(
                'Rino default settings file was not found: '
                . $file
            );
        }

        $defaults = require $file;

        if (!is_array($defaults)) {
            throw new RuntimeException(
                'Rino default settings file must return an array.'
            );
        }

        return $defaults;
    }

    public static function get(
        string $key
    ): ?array {
        $setting =
            self::all()[$key]
            ?? null;

        return is_array($setting)
            ? $setting
            : null;
    }

    public static function value(
        string $key,
        mixed $fallback = null
    ): mixed {
        return self::get($key)['value']
            ?? $fallback;
    }
}
