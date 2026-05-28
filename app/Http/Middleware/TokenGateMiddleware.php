<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenGateMiddleware
{
    //
    // TokenGate: Session-bound random access token.
    // Every protected route requires a randomized query parameter
    // containing a valid session token. Bots scanning raw URLs
    // without an active session will always fail.
    // Token + param name are regenerated periodically to prevent replay & link sharing.
    //

    const SESSION_KEY_TOKEN = '_tg_tok';
    const SESSION_KEY_PARAM = '_tg_par';
    const SESSION_KEY_TIME  = '_tg_ts';
    const TOKEN_TTL         = 7200; // 2 hour rotation

    // Obfuscated decoy destinations (rot13 encoded)
    private $decoyPool = [
        'uggcf://ra.jvxvcrqvn.bet',
        'uggcf://fgnpxbiresybj.pbz',
        'uggcf://tvguho.pbz',
        'uggcf://jjj.erqqvg.pbz',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Initialize or rotate session token
        $this->ensureToken($request);

        // Get the current param name (randomized per session)
        $paramName = session(self::SESSION_KEY_PARAM);
        $storedToken = session(self::SESSION_KEY_TOKEN);

        // Check if the request carries the correct token
        $providedToken = $request->query($paramName, '');

        if ($providedToken === '' || !hash_equals($storedToken, $providedToken)) {
            // Token missing or invalid -> redirect to decoy
            return redirect()->away($this->decoyUrl());
        }

        return $next($request);
    }

    //
    // Generate or refresh the session token.
    //
    private function ensureToken(Request $request): void
    {
        $now = time();
        $lastGen = session(self::SESSION_KEY_TIME, 0);

        // Rotate if expired or first visit
        if (($now - $lastGen) > self::TOKEN_TTL) {
            session([self::SESSION_KEY_TOKEN => $this->generateToken()]);
            session([self::SESSION_KEY_PARAM => $this->generateParamName()]);
            session([self::SESSION_KEY_TIME  => $now]);
        }
    }

    //
    // Generate a cryptographically random token.
    //
    private function generateToken(): string
    {
        return bin2hex(random_bytes(16)); // 32-char hex
    }

    //
    // Generate a random-looking query parameter name.
    // Uses a pool of innocent-looking param names so
    // bots can't fingerprint by param name.
    //
    private function generateParamName(): string
    {
        $prefixes = [
            'ref', 'src', 'utm_source', 'campaign', 'cid',
            'token', 'key', 'hash', 'nonce', 'signature',
            'tracking', 'session_id', 'visitor', 'uid',
            'flow', 'seq', 'page_id', 'route', 'node',
        ];

        $suffixes = ['', '_' . random_int(1, 999), dechex(random_int(0x1000, 0xFFFF))];

        $prefix = $prefixes[array_rand($prefixes)];
        $suffix = $suffixes[array_rand($suffixes)];

        return $prefix . $suffix;
    }

    //
    // Decode and return a random decoy URL.
    //
    private function decoyUrl(): string
    {
        $encoded = $this->decoyPool[array_rand($this->decoyPool)];
        return str_rot13($encoded);
    }
}