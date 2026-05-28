<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BotDetectionMiddleware
{
    /**
     * Bot Detection Middleware v5 - Silent (no redirect, no JS dependency)
     *
     * All bot detection runs server-side only, zero user impact:
     * L1: Rate Limiting (30 req/min, block 5 min)
     * L2: Header Fingerprint (Accept-Lang, Accept-Encoding, Sec-Fetch, etc.)
     * L3: Behavioral Scoring (scanner paths, SQLi/XSS, honeypot URLs)
     * L4: HTML Honeypot Injection
     */

    private int $rateLimitMax    = 30;
    private int $rateLimitWindow = 60;
    private int $rateLimitBlock  = 300;

    public function handle(Request $request, Closure $next): Response
    {
        // L1: Rate Limit
        if ($this->isRateLimited($request)) {
            Log::warning('Bot blocked: rate limit', [
                'ip' => $request->ip(), 'path' => $request->path(),
            ]);
            return response('Too Many Requests', 429);
        }

        // L2 + L3: Bot Scoring
        $score = $this->headerScore($request);
        $score += $this->behavioralScore($request);

        if ($score >= 5) {
            Log::warning('Bot blocked (score: ' . $score . ')', [
                'ip' => $request->ip(), 'ua' => $request->userAgent(), 'path' => $request->path(),
            ]);
            return response('Forbidden', 403);
        }

        $this->recordHit($request);

        $response = $next($request);

        // L4: Inject honeypots into HTML
        if ($this->isHtmlResponse($response)) {
            $this->injectHoneypots($response);
        }

        return $response;
    }

    // ============================================================
    // L1: Rate Limiting
    // ============================================================

    private function isRateLimited(Request $request): bool
    {
        $ip = $request->ip();
        if (Cache::has('rate_block_' . md5($ip))) return true;

        $hits = Cache::get('rate_limit_' . md5($ip), 0);
        if ($hits >= $this->rateLimitMax) {
            Cache::put('rate_block_' . md5($ip), time(), $this->rateLimitBlock);
            Log::warning("Rate limit exceeded: {$ip}");
            return true;
        }
        return false;
    }

    private function recordHit(Request $request): void
    {
        $ip  = $request->ip();
        $key = 'rate_limit_' . md5($ip);
        $hits = Cache::get($key, 0);
        if ($hits === 0) {
            Cache::put($key, 1, $this->rateLimitWindow);
        } else {
            Cache::increment($key);
        }
    }

    // ============================================================
    // L2: Header Fingerprint
    // ============================================================

    private function headerScore(Request $request): int
    {
        $flags = 0;
        $ua    = strtolower($request->userAgent() ?? '');

        if (!$request->headers->has('Accept-Language')) $flags += 2;
        if (!$request->headers->has('Accept-Encoding')) $flags += 2;

        $accept = strtolower($request->headers->get('Accept', ''));
        if ($accept === '' || $accept === '*/*') $flags += 1;

        // Missing Sec-Fetch-* on modern-browser UA
        if (!$request->headers->has('Sec-Fetch-Dest') &&
            !$request->headers->has('Sec-Fetch-Mode') &&
            !$request->headers->has('Sec-Fetch-Site')) {
            if (str_contains($ua, 'chrome') || str_contains($ua, 'edge') || str_contains($ua, 'firefox')) {
                $flags += 2;
            }
        }

        // UA pattern anomalies
        if (strtolower($request->headers->get('Connection', '')) === 'close') $flags += 1;
        if (strlen($ua) < 30 && $ua !== '') $flags += 2;

        // Known automation tools
        $auto = ['headless', 'puppeteer', 'selenium', 'phantom', 'playwright',
            'cypress', 'webdriver', 'postman', 'insomnia', 'curl', 'wget',
            'python', 'requests', 'aiohttp', 'axios', 'node-fetch',
            'go-http', 'scrapy', 'scraper', 'crawler', 'spider'];
        foreach ($auto as $p) {
            if (str_contains($ua, $p)) { $flags += 4; break; }
        }

        return min($flags, 5);
    }

    // ============================================================
    // L3: Behavioral Scoring
    // ============================================================

    private function behavioralScore(Request $request): int
    {
        $flags = 0;
        $path  = strtolower($request->path());
        $url   = $request->fullUrl();

        // Vulnerability scanner paths
        $scanner = ['.env', 'wp-admin', 'wp-login', 'phpmyadmin', 'wp-content',
            '.git', '.aws', '.config', 'administrator', 'config.php',
            'setup.php', 'install', 'shell', 'cmd', 'exec',
            'config/secret', '.ssh', '.bash_history', 'id_rsa',
            'adminer', 'phpinfo', 'info.php', 'test.php',
            'backup', 'dump', 'export', 'db', 'actuator', 'swagger', 'graphql'];
        foreach ($scanner as $sp) {
            if (str_contains($path, $sp)) { $flags += 3; break; }
        }

        // Honeypot URLs
        foreach (['.config/secret', 'wp-admin', '.env'] as $hp) {
            if (str_contains($path, $hp)) {
                Log::warning('Honeypot triggered', [
                    'ip' => $request->ip(), 'path' => $request->path(),
                ]);
                $flags += 5; break;
            }
        }

        // Excessive query params
        if (count($request->query()) > 20) $flags += 2;

        // SQL injection
        $sqli = ['union+select', 'union all select', 'or 1=1', "or '1'='1",
            'information_schema', 'pg_sleep', 'sleep(', 'benchmark(',
            '../', '..\\', 'etc/passwd', '/bin/'];
        foreach ($sqli as $p) {
            if (stripos($url, $p) !== false) { $flags += 4; break; }
        }

        // XSS
        foreach (['<script', 'javascript:', 'onerror=', 'onload=', '<img', '<svg'] as $p) {
            if (stripos($url, $p) !== false) { $flags += 4; break; }
        }

        return min($flags, 5);
    }

    // ============================================================
    // L4: Honeypot Injection
    // ============================================================

    private function injectHoneypots(Response $response): void
    {
        $content = $response->getContent();
        if (!$content) return;

        $hp = '<div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;opacity:0.01" aria-hidden="true">'
            . '<a href="/.config/secret">admin</a>'
            . '<a href="/wp-admin">login</a>'
            . '<a href="/.env">config</a>'
            . '<form action="/.config/secret" method="post"><input type="text" name="user"><input type="password" name="pass"><input type="submit" value="Login"></form>'
            . '</div>';

        $content = str_replace('<body>', "<body>\n" . $hp, $content);
        $content = str_replace('<body ', "<body \n" . $hp, $content);

        $response->setContent($content);
    }

    // ============================================================
    // Utility
    // ============================================================

    private function isHtmlResponse($response): bool
    {
        if (!method_exists($response, 'headers')) return false;
        return str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }
}