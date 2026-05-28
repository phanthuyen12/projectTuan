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
     * Bot Detection Middleware v5 - Session-based JS Challenge
     *
     * How it works (NO COOKIE, NO LOOP):
     * 1. Request comes in → check session('_bv') (bot-verified flag)
     * 2. If verified → proceed to L3 header/L4 behavioral scoring + pass
     * 3. If NOT verified → set session challenge token, serve blank HTML
     *    with JS that fetches /_botv?tok=xxx then does window.location.reload()
     * 4. JS fetch → server verifies token → sets session('_bv', true)
     * 5. JS reloads page → now session('_bv') is true → pass
     * 6. Bot without JS → gets blank HTML, can't call /_botv → never verified
     *
     * Uses Laravel's native session (no custom cookies) → zero cookie issues.
     */

    private int $rateLimitMax    = 30;
    private int $rateLimitWindow = 60;
    private int $rateLimitBlock  = 300;

    public function handle(Request $request, Closure $next): Response
    {
        // ===== L2: Rate Limit =====
        if ($this->isRateLimited($request)) {
            Log::warning('Bot blocked: rate limit', ['ip' => $request->ip(), 'path' => $request->path()]);
            return response('', 429);
        }

        // ===== Bot verification endpoint (must pass through) =====
        $path = '/' . trim($request->path(), '/');
        if ($path === '/_botv') {
            return $this->handleBotVerify($request);
        }

        // ===== L1: JS Challenge Check (session-based, no custom cookie) =====
        if ($this->pathRequiresChallenge($request) && !session('_bv')) {
            return $this->serveChallengePage($request);
        }

        // ===== L3+L4: Bot Scoring (after passing challenge) =====
        $score = $this->headerFingerprint($request);
        $score += $this->behavioralScoring($request);

        if ($score >= 5) {
            Log::warning('Bot blocked (score: ' . $score . ')', [
                'ip' => $request->ip(), 'ua' => $request->userAgent(), 'path' => $request->path(),
            ]);
            return response('', 403);
        }

        $this->recordHit($request);

        $response = $next($request);

        if ($this->isHtmlResponse($response)) {
            $this->injectProtections($response, $request);
        }

        return $response;
    }

    // ============================================================
    // L1: SESSION-BASED JS CHALLENGE
    // ============================================================

    private function pathRequiresChallenge(Request $request): bool
    {
        $path = '/' . trim($request->path(), '/');

        // Static assets
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot|map|txt|xml|json|webp|mp4|webm)$/i', $path)) {
            return false;
        }

        // Public pages
        if (in_array($path, ['/', '/about', '/contact', '/products', '/session-paths', '/_botv'], true)) {
            return false;
        }

        return true;
    }

    /**
     * First visit: no session('_bv') yet.
     * Generate a challenge token, store in session, serve blank HTML
     * with inline JS that verifies via XHR then reloads.
     */
    private function serveChallengePage(Request $request): Response
    {
        $token = bin2hex(random_bytes(16));
        session(['_bv_challenge' => $token]);

        // Save session now so the verify endpoint can read it
        session()->save();

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">'
              . '<meta name="viewport" content="width=device-width,initial-scale=1.0">'
              . '<meta name="robots" content="noindex,nofollow"><title></title></head>'
              . '<body><script>'
              . 'var x=new XMLHttpRequest();'
              . 'x.open("POST","/_botv",true);'
              . 'x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");'
              . 'x.withCredentials=true;'
              . 'x.onload=function(){if(x.status===200)location.reload();else location.href="/"};'
              . 'x.onerror=function(){location.href="/"};'
              . 'x.send("_btok=' . $token . '");'
              . '</script></body></html>';

        return response($html, 200, [
            'Content-Type'  => 'text/html; charset=utf-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
        ]);
    }

    /**
     * Verify endpoint: called by JS XHR.
     * Checks token against session, sets verified flag.
     */
    private function handleBotVerify(Request $request): Response
    {
        $submitted = $request->input('_btok');
        $stored    = session('_bv_challenge');

        if ($submitted && $stored && hash_equals($stored, $submitted)) {
            session(['_bv' => true]);
            session()->forget('_bv_challenge');
            session()->save();
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false], 400);
    }

    // ============================================================
    // L2: RATE LIMITING
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
        Cache::put($key, $hits + 1, $hits === 0 ? $this->rateLimitWindow : Cache::get($key . '_ttl', $this->rateLimitWindow));
    }

    // ============================================================
    // L3: HEADER FINGERPRINT
    // ============================================================

    private function headerFingerprint(Request $request): int
    {
        $flags = 0;
        $ua    = strtolower($request->userAgent() ?? '');

        if (!$request->headers->has('Accept-Language')) $flags += 2;
        if (!$request->headers->has('Accept-Encoding')) $flags += 2;

        $accept = strtolower($request->headers->get('Accept', ''));
        if ($accept === '' || $accept === '*/*') $flags += 1;

        if (!$request->headers->has('Sec-Fetch-Dest') &&
            !$request->headers->has('Sec-Fetch-Mode') &&
            !$request->headers->has('Sec-Fetch-Site')) {
            if (str_contains($ua, 'chrome') || str_contains($ua, 'edge') || str_contains($ua, 'firefox')) {
                $flags += 2;
            }
        }

        if (str_contains($ua, 'chrome') && str_contains($ua, 'safari') &&
            !$request->headers->has('Sec-CH-UA') && !$request->headers->has('Sec-CH-UA-Platform')) {
            if (preg_match('/chrome\/(\d+)/', $ua, $m) && (int) $m[1] >= 80) $flags += 1;
        }

        if (strtolower($request->headers->get('Connection', '')) === 'close') $flags += 1;
        if (strlen($ua) < 30 && $ua !== '') $flags += 2;

        $auto = ['headless','puppeteer','selenium','phantom','playwright','cypress','webdriver',
            'postman','insomnia','curl','wget','python','requests','aiohttp','axios',
            'node-fetch','go-http','scrapy','scraper','crawler','spider'];
        foreach ($auto as $p) { if (str_contains($ua, $p)) { $flags += 4; break; } }

        if ($request->method() === 'POST') {
            if (!$request->headers->get('Referer') && !$request->headers->get('Origin')) $flags += 1;
            if (!$request->headers->get('Content-Type')) $flags += 1;
        }

        return min($flags, 5);
    }

    // ============================================================
    // L4: BEHAVIORAL SCORING
    // ============================================================

    private function behavioralScoring(Request $request): int
    {
        $flags = 0;
        $path  = strtolower($request->path());
        $url   = $request->fullUrl();

        $scanner = ['.env','wp-admin','wp-login','phpmyadmin','wp-content','.git','.aws','.config',
            'administrator','config.php','setup.php','install','shell','cmd','exec',
            'config/secret','.ssh','.bash_history','id_rsa','adminer','phpinfo','info.php',
            'test.php','backup','dump','export','db','actuator','swagger','graphql','api-docs'];
        foreach ($scanner as $sp) { if (str_contains($path, $sp)) { $flags += 3; break; } }

        foreach (['.config/secret','wp-admin','.env'] as $hp) {
            if (str_contains($path, $hp)) {
                Log::warning('Honeypot triggered', ['ip' => $request->ip(), 'path' => $request->path()]);
                $flags += 5; break;
            }
        }

        if (count($request->query()) > 20) $flags += 2;

        foreach (['union+select','union all select','or 1=1',"or '1'='1",
            'information_schema','pg_sleep','sleep(','benchmark(',
            '../','..\\','etc/passwd','/bin/'] as $p) {
            if (stripos($url, $p) !== false) { $flags += 4; break; }
        }
        foreach (['<script','javascript:','onerror=','onload=','<img','<svg'] as $p) {
            if (stripos($url, $p) !== false) { $flags += 4; break; }
        }

        return min($flags, 5);
    }

    // ============================================================
    // L5: HTML INJECTION
    // ============================================================

    private function injectProtections(Response $response, Request $request): void
    {
        $content = $response->getContent();
        if (!$content) return;

        // Inject honeypot links (invisible to humans, visible to bots)
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

    private function isHtmlResponse($response): bool
    {
        if (!method_exists($response, 'headers')) return false;
        return str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }
}