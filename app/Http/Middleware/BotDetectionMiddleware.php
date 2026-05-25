<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BotDetectionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = strtolower($request->userAgent() ?? '');

        $botAgents = [
            'bot', 'spider', 'crawl', 'wget', 'curl', 'slurp',
            'facebookexternalhit', 'twitterbot', 'whatsapp', 'telegrambot',
            'discordbot', 'linkedinbot', 'bingbot', 'googlebot', 'yandexbot',
            'duckduckbot', 'baiduspider', 'ahrefsbot', 'semrushbot',
            'mj12bot', 'dotbot', 'headlesschrome', 'puppeteer',
            'selenium', 'phantomjs', 'postmanruntime',
        ];

        $isBot = $userAgent === '';
        foreach ($botAgents as $needle) {
            if (str_contains($userAgent, $needle)) {
                $isBot = true;
                break;
            }
        }

        $missingHeaders = !$request->headers->has('Accept-Language');

        if ($isBot || $missingHeaders) {
            Log::warning('Blocked automated request', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
            ]);

            return redirect('xxx.com'); // Redirect bots to a neutral site instead of blocking them outright
            // Hoac dung: abort(403, 'Automated access is not allowed.');
        }

        return $next($request);
    }
}