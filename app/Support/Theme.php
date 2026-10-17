<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class Theme
{
    public static function settings(): array
    {
        $settings = Schema::hasTable('settings')
            ? Setting::query()
                ->where('group', 'appearance')
                ->pluck('value', 'key')
            : collect();

        return [
            'default_mode' =>
                $settings->get(
                    'theme_default_mode',
                    'dark'
                ),

            'allow_switch' =>
                $settings->get(
                    'theme_allow_switch',
                    '1'
                )
                ===
                '1',

            'dark' => [
                'background' =>
                    $settings->get(
                        'dark_background',
                        '#09090b'
                    ),

                'surface' =>
                    $settings->get(
                        'dark_surface',
                        '#18181b'
                    ),

                'surface_secondary' =>
                    $settings->get(
                        'dark_surface_secondary',
                        '#27272a'
                    ),

                'border' =>
                    $settings->get(
                        'dark_border',
                        '#3f3f46'
                    ),

                'text_heading' =>
                    $settings->get(
                        'dark_text_heading',
                        '#ffffff'
                    ),

                'text_body' =>
                    $settings->get(
                        'dark_text_body',
                        '#d4d4d8'
                    ),

                'text_muted' =>
                    $settings->get(
                        'dark_text_muted',
                        '#a1a1aa'
                    ),

                'primary' =>
                    $settings->get(
                        'dark_primary',
                        '#193CD2'
                    ),

                'primary_hover' =>
                    $settings->get(
                        'dark_primary_hover',
                        '#1533B5'
                    ),

                'primary_text' =>
                    $settings->get(
                        'dark_primary_text',
                        '#ffffff'
                    ),
            ],

            'light' => [
                'background' =>
                    $settings->get(
                        'light_background',
                        '#ffffff'
                    ),

                'surface' =>
                    $settings->get(
                        'light_surface',
                        '#fafafa'
                    ),

                'surface_secondary' =>
                    $settings->get(
                        'light_surface_secondary',
                        '#f4f4f5'
                    ),

                'border' =>
                    $settings->get(
                        'light_border',
                        '#d4d4d8'
                    ),

                'text_heading' =>
                    $settings->get(
                        'light_text_heading',
                        '#18181b'
                    ),

                'text_body' =>
                    $settings->get(
                        'light_text_body',
                        '#3f3f46'
                    ),

                'text_muted' =>
                    $settings->get(
                        'light_text_muted',
                        '#71717a'
                    ),

                'primary' =>
                    $settings->get(
                        'light_primary',
                        '#193CD2'
                    ),

                'primary_hover' =>
                    $settings->get(
                        'light_primary_hover',
                        '#1533B5'
                    ),

                'primary_text' =>
                    $settings->get(
                        'light_primary_text',
                        '#ffffff'
                    ),
            ],

            'typography' => [
                'body_font' =>
                    $settings->get(
                        'body_font',
                        'manrope'
                    ),

                'heading_font' =>
                    $settings->get(
                        'heading_font',
                        'manrope'
                    ),

                'base_font_size' =>
                    (int) $settings->get(
                        'base_font_size',
                        16
                    ),
            ],

            'radius' => [
                'card' =>
                    (int) $settings->get(
                        'card_radius',
                        12
                    ),

                'button' =>
                    (int) $settings->get(
                        'button_radius',
                        32
                    ),

                'input' =>
                    (int) $settings->get(
                        'input_radius',
                        12
                    ),
            ],
        ];
    }

    public static function fontFamily(
        string $font
    ): string {
        return match (
            $font
        ) {
            'inter' =>
                "'Inter', sans-serif",

            'geist' =>
                "'Geist', sans-serif",

            'manrope' =>
                "'Manrope', sans-serif",

            'dm-sans' =>
                "'DM Sans', sans-serif",

            'plus-jakarta-sans' =>
                "'Plus Jakarta Sans', sans-serif",

            'outfit' =>
                "'Outfit', sans-serif",

            'space-grotesk' =>
                "'Space Grotesk', sans-serif",

            default =>
                "ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
        };
    }

    public static function googleFontName(
        string $font
    ): ?string {
        return match (
            $font
        ) {
            'inter' =>
                'Inter',

            'geist' =>
                'Geist',

            'manrope' =>
                'Manrope',

            'dm-sans' =>
                'DM Sans',

            'plus-jakarta-sans' =>
                'Plus Jakarta Sans',

            'outfit' =>
                'Outfit',

            'space-grotesk' =>
                'Space Grotesk',

            default =>
                null,
        };
    }

    public static function googleFontsUrl(
        string $bodyFont,
        string $headingFont
    ): ?string {
        $fonts =
            array_values(
                array_unique(
                    array_filter([
                        self::googleFontName(
                            $bodyFont
                        ),

                        self::googleFontName(
                            $headingFont
                        ),
                    ])
                )
            );

        if (
            empty(
                $fonts
            )
        ) {
            return null;
        }

        $families = [];

        foreach (
            $fonts
            as $font
        ) {
            $family =
                str_replace(
                    ' ',
                    '+',
                    $font
                );

            $families[] =
                'family='
                .
                $family
                .
                ':wght@400;500;600;700;800';
        }

        return
            'https://fonts.googleapis.com/css2?'
            .
            implode(
                '&',
                $families
            )
            .
            '&display=swap';
    }
}
