<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $response =
            $next($request);

        if (
            !$this->shouldTrack(
                $request,
                $response
            )
        ) {
            return $response;
        }

        $visitorId =
            $request->cookie(
                'rino_visitor'
            );

        $newVisitor =
            false;

        if (!$visitorId) {
            $visitorId =
                (string) Str::uuid();

            $newVisitor =
                true;
        }

        SiteVisit::query()
            ->create([
                'visitor_id' =>
                    $visitorId,

                'session_id' =>
                    $request
                        ->hasSession()
                            ? $request
                                ->session()
                                ->getId()
                            : null,

                'path' =>
                    '/'
                    .
                    ltrim(
                        $request->path(),
                        '/'
                    ),

                'route_name' =>
                    $request
                        ->route()
                        ?->getName(),

                'referrer_host' =>
                    $this->referrerHost(
                        $request
                    ),

                'ip_hash' =>
                    $request->ip()
                        ? hash_hmac(
                            'sha256',
                            $request->ip(),
                            (string) config(
                                'app.key'
                            )
                        )
                        : null,

                'user_agent' =>
                    Str::limit(
                        (string) $request
                            ->userAgent(),
                        1000,
                        ''
                    ),

                'viewed_at' =>
                    now(),
            ]);

        if ($newVisitor) {
            $response
                ->headers
                ->setCookie(
                    cookie(
                        'rino_visitor',
                        $visitorId,
                        60 * 24 * 365,
                        '/',
                        null,
                        $request->isSecure(),
                        true,
                        false,
                        'lax'
                    )
                );
        }

        return $response;
    }

    private function shouldTrack(
        Request $request,
        Response $response
    ): bool {
        if (
            !$request->isMethod(
                'GET'
            )
        ) {
            return false;
        }

        if (
            $request->is(
                'admin'
            )
            ||
            $request->is(
                'admin/*'
            )
        ) {
            return false;
        }

        if (
            $response->getStatusCode()
            >= 400
        ) {
            return false;
        }

        $settings =
            Setting::query()
                ->whereIn(
                    'key',
                    [
                        'cookie_consent_enabled',
                        'cookie_analytics_enabled',
                    ]
                )
                ->pluck(
                    'value',
                    'key'
                );

        $analyticsEnabled =
            filter_var(
                $settings->get(
                    'cookie_analytics_enabled',
                    true
                ),
                FILTER_VALIDATE_BOOLEAN
            );

        if (!$analyticsEnabled) {
            return false;
        }

        $consentEnabled =
            filter_var(
                $settings->get(
                    'cookie_consent_enabled',
                    true
                ),
                FILTER_VALIDATE_BOOLEAN
            );

        if (
            $consentEnabled
            &&
            $request->cookie(
                'rino_cookie_consent'
            )
            !==
            'analytics'
        ) {
            return false;
        }

        $userAgent =
            strtolower(
                (string) $request
                    ->userAgent()
            );

        $bots = [
            'bot',
            'crawler',
            'spider',
            'slurp',
            'bingpreview',
            'facebookexternalhit',
            'headlesschrome',
        ];

        foreach (
            $bots
            as $bot
        ) {
            if (
                str_contains(
                    $userAgent,
                    $bot
                )
            ) {
                return false;
            }
        }

        return true;
    }

    private function referrerHost(
        Request $request
    ): ?string {
        $referrer =
            $request->headers->get(
                'referer'
            );

        if (!$referrer) {
            return null;
        }

        $host =
            parse_url(
                $referrer,
                PHP_URL_HOST
            );

        if (!$host) {
            return null;
        }

        $currentHost =
            $request->getHost();

        if (
            strtolower($host)
            ===
            strtolower($currentHost)
        ) {
            return null;
        }

        return strtolower(
            $host
        );
    }
}
