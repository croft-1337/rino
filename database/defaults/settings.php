<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Appearance
    |--------------------------------------------------------------------------
    */

    'theme_default_mode' => [
        'value' => 'dark',
        'type' => 'text',
        'group' => 'appearance',
    ],

    'theme_allow_switch' => [
        'value' => '1',
        'type' => 'boolean',
        'group' => 'appearance',
    ],

    'theme_preset' => [
        'value' => 'default',
        'type' => 'text',
        'group' => 'appearance',
    ],


    /*
    |--------------------------------------------------------------------------
    | Dark Theme
    |--------------------------------------------------------------------------
    */

    'dark_background' => [
        'value' => '#09090b',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_surface' => [
        'value' => '#18181b',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_surface_secondary' => [
        'value' => '#27272a',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_border' => [
        'value' => '#3f3f46',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_text_heading' => [
        'value' => '#ffffff',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_text_body' => [
        'value' => '#d4d4d8',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_text_muted' => [
        'value' => '#a1a1aa',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_primary' => [
        'value' => '#2563EB',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_primary_hover' => [
        'value' => '#1D4ED8',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'dark_primary_text' => [
        'value' => '#ffffff',
        'type' => 'color',
        'group' => 'appearance',
    ],


    /*
    |--------------------------------------------------------------------------
    | Light Theme
    |--------------------------------------------------------------------------
    */

    'light_background' => [
        'value' => '#ffffff',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_surface' => [
        'value' => '#fafafa',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_surface_secondary' => [
        'value' => '#f4f4f5',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_border' => [
        'value' => '#d4d4d8',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_text_heading' => [
        'value' => '#18181b',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_text_body' => [
        'value' => '#3f3f46',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_text_muted' => [
        'value' => '#71717a',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_primary' => [
        'value' => '#2563EB',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_primary_hover' => [
        'value' => '#1D4ED8',
        'type' => 'color',
        'group' => 'appearance',
    ],

    'light_primary_text' => [
        'value' => '#ffffff',
        'type' => 'color',
        'group' => 'appearance',
    ],


    /*
    |--------------------------------------------------------------------------
    | Typography / Customization
    |--------------------------------------------------------------------------
    */

    'body_font' => [
        'value' => 'manrope',
        'type' => 'text',
        'group' => 'appearance',
    ],

    'heading_font' => [
        'value' => 'manrope',
        'type' => 'text',
        'group' => 'appearance',
    ],

    'base_font_size' => [
        'value' => '16',
        'type' => 'number',
        'group' => 'appearance',
    ],

    'card_radius' => [
        'value' => '12',
        'type' => 'number',
        'group' => 'appearance',
    ],

    'button_radius' => [
        'value' => '32',
        'type' => 'number',
        'group' => 'appearance',
    ],

    'input_radius' => [
        'value' => '12',
        'type' => 'number',
        'group' => 'appearance',
    ],


    /*
    |--------------------------------------------------------------------------
    | General Site Settings
    |--------------------------------------------------------------------------
    */

    'site_name' => [
        'value' => 'Rino',
        'type' => 'text',
        'group' => 'general',
    ],

    'site_tagline' => [
        'value' => 'Fast, reliable hosting built for modern projects.',
        'type' => 'text',
        'group' => 'general',
    ],

    'contact_email' => [
        'value' => '',
        'type' => 'email',
        'group' => 'contact',
    ],

    'site_logo' => [
        'value' => 'branding/rino-logo.png',
        'type' => 'image',
        'group' => 'branding',
    ],

    'site_favicon' => [
        'value' => '',
        'type' => 'image',
        'group' => 'branding',
    ],


    /*
    |--------------------------------------------------------------------------
    | Client Area
    |--------------------------------------------------------------------------
    */

    'client_area_label' => [
        'value' => 'Client Area',
        'type' => 'text',
        'group' => 'header',
    ],

    'client_area_links' => [
        'value' => json_encode([
            [
                'label' => 'Billing Panel',
                'url' => '#',
                'icon' => 'credit-card',
                'new_tab' => false,
            ],
            [
                'label' => 'Game Panel',
                'url' => '#',
                'icon' => 'gamepad',
                'new_tab' => false,
            ],
        ]),
        'type' => 'json',
        'group' => 'header',
    ],


    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    'default_language' => [
        'value' => 'en',
        'type' => 'text',
        'group' => 'language',
    ],

    'enabled_languages' => [
        'value' => json_encode([
            'en',
            'de',
            'fr',
            'es',
        ]),
        'type' => 'json',
        'group' => 'language',
    ],


    /*
    |--------------------------------------------------------------------------
    | Announcement Bar
    |--------------------------------------------------------------------------
    */

    'announcement_enabled' => [
        'value' => '1',
        'type' => 'boolean',
        'group' => 'announcement',
    ],

    'announcement_message' => [
        'value' => 'Welcome to Rino Hosting! Fast, reliable hosting at prices that make sense.',
        'type' => 'text',
        'group' => 'announcement',
    ],

    'announcement_highlight' => [
        'value' => 'SAVE20',
        'type' => 'text',
        'group' => 'announcement',
    ],

    'announcement_dismissible' => [
        'value' => '1',
        'type' => 'boolean',
        'group' => 'announcement',
    ],

    'announcement_link_enabled' => [
        'value' => '0',
        'type' => 'boolean',
        'group' => 'announcement',
    ],

    'announcement_link_text' => [
        'value' => 'Learn More',
        'type' => 'text',
        'group' => 'announcement',
    ],

    'announcement_link_url' => [
        'value' => '',
        'type' => 'text',
        'group' => 'announcement',
    ],

    'announcement_open_new_tab' => [
        'value' => '0',
        'type' => 'boolean',
        'group' => 'announcement',
    ],


    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    */

    'footer_description' => [
        'value' => 'Fast, reliable hosting built for websites, game servers, applications, and growing online projects.',
        'type' => 'text',
        'group' => 'footer',
    ],

    'footer_copyright' => [
        'value' =>
            '© '
            . date('Y')
            . ' Rino. All rights reserved.',

        'type' => 'text',
        'group' => 'footer',
    ],

    'footer_show_payments' => [
        'value' => '1',
        'type' => 'boolean',
        'group' => 'footer',
    ],

    'footer_show_site_logo' => [
        'value' => '1',
        'type' => 'boolean',
        'group' => 'footer',
    ],

    'footer_payment_methods' => [
        'value' => '[]',
        'type' => 'json',
        'group' => 'footer',
    ],


    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'default_currency' => [
        'value' => 'USD',
        'type' => 'text',
        'group' => 'currency',
    ],

    'enabled_currencies' => [
        'value' => json_encode([
            'USD',
            'EUR',
            'GBP',
            'CAD',
            'AUD',
        ]),
        'type' => 'textarea',
        'group' => 'currency',
    ],

    'currency_rate_mode' => [
        'value' => 'automatic',
        'type' => 'text',
        'group' => 'currency',
    ],

    'currency_manual_rates' => [
        'value' => '{"USD":1}',
        'type' => 'textarea',
        'group' => 'currency',
    ],

    'currency_rates' => [
        'value' => '{"USD":1}',
        'type' => 'textarea',
        'group' => 'currency',
    ],

    'currency_rates_provider' => [
        'value' => 'frankfurter',
        'type' => 'text',
        'group' => 'currency',
    ],

    'currency_rates_updated_at' => [
        'value' => '',
        'type' => 'text',
        'group' => 'currency',
    ],

    'currency_rates_provider_date' => [
        'value' => '',
        'type' => 'text',
        'group' => 'currency',
    ],

];