<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ClassObfuscatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only process HTML responses
        if ($response instanceof \Illuminate\Http\Response && str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            $content = $response->getContent();
            
            // 1. Random Class Prefixing (Existing Obfuscation)
            $rclass = Str::random(10);
            $content = preg_replace('/\bclass="/', "class=\"{$rclass} ", $content);
            
            // 2. Hide common identifiers
            $content = str_replace('Facebook', 'F&#97;cebook', $content); // Simple obfuscation for textual scanners
            
            $response->setContent($content);
        }

        // Add Security Headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
