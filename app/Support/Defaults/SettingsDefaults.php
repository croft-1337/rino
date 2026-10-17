<?php

namespace App\Support\Defaults;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SettingsDefaults
{
    private const DEFAULT_LOGO_SOURCE =
        'assets/branding/rino-logo.png';

    private const DEFAULT_LOGO_STORAGE =
        'branding/rino-logo.png';

    /**
     * Seed settings that do not exist yet.
     * Existing administrator values are preserved.
     */
    public static function seed(): void
    {
        self::seedDefaultAssets();

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
        self::seedDefaultAssets();

        foreach (
            self::all()
            as $key => $definition
        ) {
            self::writeDefault(
                $key,
                $definition
            );
        }
    }

    /**
     * Reset only selected settings.
     *
     * Useful when new factory defaults are introduced
     * without overwriting unrelated administrator settings.
     */
    public static function resetKeys(
        array $keys
    ): void {
        self::seedDefaultAssets();

        $defaults =
            self::all();

        foreach ($keys as $key) {
            $definition =
                $defaults[$key]
                ?? null;

            if (
                !is_string($key)
                ||
                $key === ''
                ||
                !is_array($definition)
            ) {
                continue;
            }

            self::writeDefault(
                $key,
                $definition
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

        $defaults =
            require $file;

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

    private static function writeDefault(
        string $key,
        array $definition
    ): void {
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

    private static function seedDefaultAssets(): void
    {
        $source =
            public_path(
                self::DEFAULT_LOGO_SOURCE
            );

        if (!is_file($source)) {
            throw new RuntimeException(
                'Default Rino logo was not found: '
                . $source
            );
        }

        $contents =
            file_get_contents(
                $source
            );

        if ($contents === false) {
            throw new RuntimeException(
                'Unable to read default Rino logo: '
                . $source
            );
        }

        Storage::disk('public')
            ->put(
                self::DEFAULT_LOGO_STORAGE,
                $contents
            );
    }
}