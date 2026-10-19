<?php

namespace App\Support;

use App\Models\Page;
use App\Models\PageCategory;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Support\Currency\CurrencyService;
use Illuminate\Support\Facades\Storage;

class SiteData
{
    public static function get(): array
    {
        $settings =
            Setting::pluck(
                'value',
                'key'
            );

        $siteLogo =
            $settings->get(
                'site_logo'
            );

        $siteFavicon =
            $settings->get(
                'site_favicon'
            );

        $currency =
            app(
                CurrencyService::class
            );

        $defaultCurrency =
            $currency->base();

        $enabledCurrencies =
            $currency->enabled();

        $selectedCurrency =
            $currency->selected();

        $currencyData =
            $currency->frontend();

        $currencyNames =
            collect(
                $currencyData[
                    'currencies'
                ]
            )
                ->mapWithKeys(
                    fn (
                        array $data,
                        string $code
                    ): array => [
                        $code =>
                            $data['name'],
                    ]
                )
                ->all();

        $headerCategories =
            PageCategory::query()
                ->whereHas(
                    'pages',
                    function ($query) {
                        $query
                            ->where(
                                'active',
                                true
                            )
                            ->where(
                                'show_in_header',
                                true
                            );
                    }
                )
                ->with([
                    'pages' =>
                        function ($query) {
                            $query
                                ->where(
                                    'active',
                                    true
                                )
                                ->where(
                                    'show_in_header',
                                    true
                                )
                                ->orderBy(
                                    'sort_order'
                                )
                                ->orderBy(
                                    'id'
                                );
                        },
                ])
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'id'
                )
                ->get();

        $headerStandaloneItems =
            Page::query()
                ->whereNull(
                    'category_id'
                )
                ->where(
                    'active',
                    true
                )
                ->where(
                    'show_in_header',
                    true
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'id'
                )
                ->get();

        $footerCategories =
            PageCategory::query()
                ->whereHas(
                    'pages',
                    function ($query) {
                        $query
                            ->where(
                                'active',
                                true
                            )
                            ->where(
                                'show_in_footer',
                                true
                            );
                    }
                )
                ->with([
                    'pages' =>
                        function ($query) {
                            $query
                                ->where(
                                    'active',
                                    true
                                )
                                ->where(
                                    'show_in_footer',
                                    true
                                )
                                ->orderBy(
                                    'sort_order'
                                )
                                ->orderBy(
                                    'id'
                                );
                        },
                ])
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'id'
                )
                ->get();

        $headerSocialLinks =
            SocialLink::query()
                ->where(
                    'show_in_header',
                    true
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'id'
                )
                ->limit(3)
                ->get();

        $footerSocialLinks =
            SocialLink::query()
                ->where(
                    'show_in_footer',
                    true
                )
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'id'
                )
                ->get();

        $clientAreaLinks =
            json_decode(
                $settings->get(
                    'client_area_links',
                    '[]'
                ),
                true
            );

        if (
            !is_array(
                $clientAreaLinks
            )
        ) {
            $clientAreaLinks = [];
        }

        $footerPaymentMethods =
            json_decode(
                $settings->get(
                    'footer_payment_methods',
                    '[]'
                ),
                true
            );

        if (
            !is_array(
                $footerPaymentMethods
            )
        ) {
            $footerPaymentMethods = [];
        }

        $footerPaymentMethods =
            collect(
                $footerPaymentMethods
            )
                ->filter(
                    fn ($method) =>
                        is_array(
                            $method
                        )
                        &&
                        !empty(
                            $method[
                                'enabled'
                            ]
                        )
                        &&
                        !empty(
                            $method[
                                'logo'
                            ]
                        )
                )
                ->values()
                ->all();

        $cookiePrivacyPage =
            null;

        $cookiePrivacyPageId =
            $settings->get(
                'cookie_privacy_page_id'
            );

        if (
            filled(
                $cookiePrivacyPageId
            )
        ) {
            $cookiePrivacyPage =
                Page::query()
                    ->whereKey(
                        (int) $cookiePrivacyPageId
                    )
                    ->where(
                        'active',
                        true
                    )
                    ->first();
        }

        return [
            'siteName' =>
                $settings->get(
                    'site_name',
                    'Rino'
                ),

            'siteTagline' =>
                $settings->get(
                    'site_tagline',
                    ''
                ),

            'contactEmail' =>
                $settings->get(
                    'contact_email',
                    ''
                ),

            'seoSettings' => [
                'default_title' => $settings->get('seo_default_title'),
                'description' => $settings->get('seo_meta_description'),
                'company' => $settings->get('seo_company_name'),
                'robots' => $settings->get('seo_robots', 'index,follow'),
                'social_image' => $settings->get('seo_social_image'),
                'twitter_card' => $settings->get('seo_twitter_card', 'summary_large_image'),
                'twitter_username' => $settings->get('seo_twitter_username'),
            ],

            'defaultCurrency' =>
                $defaultCurrency,

            'enabledCurrencies' =>
                $enabledCurrencies,

            'selectedCurrency' =>
                $selectedCurrency,

            'currencyNames' =>
                $currencyNames,

            'currencyData' =>
                $currencyData,

            'siteLogo' =>
                $siteLogo
                    ? Storage::url(
                        $siteLogo
                    )
                    : null,

            'siteFavicon' =>
                $siteFavicon
                    ? Storage::url(
                        $siteFavicon
                    )
                    : null,

            'headerCategories' =>
                $headerCategories,

            'headerStandaloneItems' =>
                $headerStandaloneItems,

            'headerSocialLinks' =>
                $headerSocialLinks,

            'footerCategories' =>
                $footerCategories,

            'footerSocialLinks' =>
                $footerSocialLinks,

            'clientAreaLabel' =>
                $settings->get(
                    'client_area_label',
                    'Client Area'
                ),

            'clientAreaLinks' =>
                $clientAreaLinks,

            'footerDescription' =>
                $settings->get(
                    'footer_description',
                    ''
                ),

            'footerCopyright' =>
                $settings->get(
                    'footer_copyright',
                    '© '
                    .
                    date('Y')
                    .
                    ' Rino. All rights reserved.'
                ),

            'footerShowPayments' =>
                self::boolean(
                    $settings->get(
                        'footer_show_payments',
                        true
                    )
                ),

            'footerShowSiteLogo' =>
                self::boolean(
                    $settings->get(
                        'footer_show_site_logo',
                        true
                    )
                ),

            'footerPaymentMethods' =>
                $footerPaymentMethods,

            'theme' =>
                Theme::settings(),

            'cookieConsentEnabled' =>
                self::boolean(
                    $settings->get(
                        'cookie_consent_enabled',
                        true
                    )
                ),

            'cookieConsentTitle' =>
                $settings->get(
                    'cookie_consent_title',
                    'We use cookies'
                ),

            'cookieConsentDescription' =>
                $settings->get(
                    'cookie_consent_description',
                    'We use essential cookies and optional analytics to improve the website.'
                ),

            'cookieAnalyticsEnabled' =>
                self::boolean(
                    $settings->get(
                        'cookie_analytics_enabled',
                        true
                    )
                ),

            'cookieAcceptLabel' =>
                $settings->get(
                    'cookie_accept_label',
                    'Accept'
                ),

            'cookieRejectLabel' =>
                $settings->get(
                    'cookie_reject_label',
                    'Reject Optional'
                ),

            'cookiePrivacyUrl' =>
                $cookiePrivacyPage?->url,

            'cookiePrivacyLabel' =>
                'Privacy Policy',

            'announcementEnabled' =>
                self::boolean(
                    $settings->get(
                        'announcement_enabled',
                        false
                    )
                ),

            'announcementMessage' =>
                $settings->get(
                    'announcement_message',
                    ''
                ),

            'announcementHighlight' =>
                $settings->get(
                    'announcement_highlight',
                    ''
                ),

            'announcementDismissible' =>
                self::boolean(
                    $settings->get(
                        'announcement_dismissible',
                        true
                    )
                ),

            'announcementLinkEnabled' =>
                self::boolean(
                    $settings->get(
                        'announcement_link_enabled',
                        false
                    )
                ),

            'announcementLinkText' =>
                $settings->get(
                    'announcement_link_text',
                    ''
                ),

            'announcementLinkUrl' =>
                $settings->get(
                    'announcement_link_url',
                    ''
                ),

            'announcementOpenNewTab' =>
                self::boolean(
                    $settings->get(
                        'announcement_open_new_tab',
                        false
                    )
                ),
        ];
    }

    private static function boolean(
        mixed $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
