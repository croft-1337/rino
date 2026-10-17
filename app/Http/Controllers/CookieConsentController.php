<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CookieConsentController
{
    public function __invoke(
        Request $request
    ): RedirectResponse {
        $request->validate([
            'choice' => [
                'required',
                'in:analytics,essential',
            ],
        ]);

        $analyticsEnabled =
            filter_var(
                Setting::query()
                    ->where(
                        'key',
                        'cookie_analytics_enabled'
                    )
                    ->value(
                        'value'
                    )
                    ?? true,
                FILTER_VALIDATE_BOOLEAN
            );

        $choice =
            $request
                ->string(
                    'choice'
                )
                ->toString();

        if (!$analyticsEnabled) {
            $choice =
                'essential';
        }

        $response =
            redirect()->back();

        $response->withCookie(
            cookie(
                'rino_cookie_consent',
                $choice,
                60 * 24 * 365,
                '/',
                null,
                $request->isSecure(),
                false,
                false,
                'lax'
            )
        );

        if (
            $choice ===
            'essential'
        ) {
            $response->withCookie(
                cookie()->forget(
                    'rino_visitor',
                    '/'
                )
            );
        }

        return $response;
    }
}
