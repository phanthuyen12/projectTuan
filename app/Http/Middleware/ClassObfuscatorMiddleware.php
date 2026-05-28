<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassObfuscatorMiddleware
{
    /**
     * HTML Content Obfuscation Middleware (v3 - Safe for UI)
     *
     * Techniques (does NOT touch CSS classes/IDs to preserve layout):
     * 1. Inject invisible noise spans to break regex-based scrapers
     * 2. Insert zero-width Unicode chars to corrupt text extraction
     * 3. Obfuscate form action URLs via JS-base64 decoder at runtime
     * 4. Anti-devtools detection (disable F12, right-click, Ctrl+U)
     * 5. Security headers (X-Robots-Tag noindex on sensitive pages)
     * 6. Disable print/screenshot via CSS media query
     */

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->isHtmlResponse($response)) {
            $content = $response->getContent();
            if ($content) {
                $content = $this->obfuscate($content);
                $response->setContent($content);
            }
        }

        // Security Headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Noindex on sensitive pages
        $path = '/' . trim($request->path(), '/');
        $publicPaths = ['/', '/about', '/contact', '/products'];
        if (!in_array($path, $publicPaths, true)) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        return $response;
    }

    // ================================================================
    // OBFUSCATION PIPELINE
    // ================================================================

    private function obfuscate(string $html): string
    {
        // Step 1: Form action obfuscation (hide real endpoints from raw HTML)
        $html = $this->obfuscateFormActions($html);

        // Step 2: Inject noise spans to break regex scraping
        $html = $this->injectNoise($html);

        // Step 3: Insert zero-width Unicode chars into text content
        $html = $this->injectZeroWidthChars($html);

        // Step 4: Anti-devtools script (before </body>)
        $html = $this->injectAntiDebug($html);

        return $html;
    }

    // ================================================================
    // FORM ACTION OBFUSCATION
    // ================================================================

    /**
     * Replace <form action="..."> with base64-encoded version decoded via JS.
     * Raw HTML shows gibberish; browser renders correct action instantly.
     */
    private function obfuscateFormActions(string $html): string
    {
        return preg_replace_callback(
            '/<form\b([^>]*)\baction=["\']([^"\']+)["\']([^>]*)>/i',
            function ($matches) {
                $attrsBefore = $matches[1];
                $actionUrl   = $matches[2];
                $attrsAfter  = $matches[3];
                $encoded     = base64_encode($actionUrl);

                return '<form' . $attrsBefore
                     . ' action="#" data-ae="' . $encoded . '"' . $attrsAfter . '>'
                     . '<script>document.currentScript.parentElement.setAttribute("action",atob("'
                     . $encoded . '"));document.currentScript.remove();</script>';
            },
            $html
        );
    }

    // ================================================================
    // NOISE INJECTION
    // ================================================================

    /**
     * Insert invisible <i> spans at scattered positions inside the body.
     * Humans never see them; bots try to parse them → corrupted output.
     */
    private function injectNoise(string $html): string
    {
        if (!preg_match('/(<body[^>]*>)/i', $html)) {
            return $html;
        }

        $noiseSpan = '<i style="display:none!important;visibility:hidden!important;'
                   . 'width:0!important;height:0!important;font-size:0!important;'
                   . 'line-height:0!important;opacity:0!important;'
                   . 'position:absolute!important;pointer-events:none!important;"'
                   . ' aria-hidden="true">' . $this->randomNoise() . '</i>';

        $patterns = ['/(<\/p>)/i', '/(<\/h[1-6]>)/i', '/(<\/label>)/i'];
        $counter = 0;

        foreach ($patterns as $pattern) {
            $html = preg_replace_callback($pattern, function ($m) use (&$counter, $noiseSpan) {
                $counter++;
                if ($counter % 4 === 0) {
                    return $m[1] . $noiseSpan;
                }
                return $m[1];
            }, $html);
        }

        return $html;
    }

    private function randomNoise(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789_-.';
        $len   = random_int(10, 28);
        $str   = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $str;
    }

    // ================================================================
    // ZERO-WIDTH CHARACTER INJECTION
    // ================================================================

    /**
     * Randomly insert zero-width Unicode characters inside text content.
     * Renders perfectly for humans but breaks text extraction for bots.
     */
    private function injectZeroWidthChars(string $html): string
    {
        $zwc = ["\u{200B}", "\u{200C}", "\u{200D}", "\u{FEFF}"];

        return preg_replace_callback(
            '/>([^<]{15,})</',
            function ($matches) use ($zwc) {
                $text = trim($matches[1]);
                if ($text === '') {
                    return '>' . $matches[1] . '<';
                }

                $chars  = mb_str_split($text);
                $result = '';
                foreach ($chars as $i => $char) {
                    $result .= $char;
                    if ($i > 0 && $i % random_int(5, 10) === 0 && ctype_alpha($char)) {
                        $result .= $zwc[array_rand($zwc)];
                    }
                }
                return '>' . $result . '<';
            },
            $html
        );
    }

    // ================================================================
    // ANTI-DEBUG / ANTI-DEVTOOLS
    // ================================================================

    /**
     * Inject lightweight anti-devtools detection.
     */
    private function injectAntiDebug(string $html): string
    {
        $script = <<<'JS'
<script>
(function(){
    var dtOpen=false;
    // Devtools detection via debugger timing
    setInterval(function(){
        var s=performance.now();
        debugger;
        var e=performance.now();
        if(e-s>160){dtOpen=true;}
        if(dtOpen){
            document.querySelectorAll('form').forEach(function(f){f.style.display='none';});
            document.querySelectorAll('input[type="password"],input[name*="pass"]').forEach(function(i){i.value='';});
        }
    },1000);
    // Disable right-click
    document.addEventListener('contextmenu',function(e){
        var t=e.target;
        if(t.tagName==='INPUT'||t.tagName==='TEXTAREA')return;
        e.preventDefault();return false;
    });
    // Disable Ctrl+U, Ctrl+S, F12, Ctrl+Shift+I
    document.addEventListener('keydown',function(e){
        if(e.ctrlKey&&(e.key==='u'||e.key==='U'||e.key==='s'||e.key==='S')){
            e.preventDefault();return false;
        }
        if(e.ctrlKey&&e.shiftKey&&(e.key==='i'||e.key==='I'||e.key==='c'||e.key==='C')){
            e.preventDefault();return false;
        }
        if(e.key==='F12'){e.preventDefault();return false;}
    });
    // Prevent print/screenshot
    var style=document.createElement('style');
    style.textContent='@media print{body{display:none!important}}';
    document.head.appendChild(style);
    setTimeout(function(){console.clear();},200);
})();
</script>
JS;

        if (strpos($html, '</body>') !== false) {
            $html = str_replace('</body>', $script . "\n</body>", $html);
        } else {
            $html .= $script;
        }

        return $html;
    }

    // ================================================================
    // UTILITY
    // ================================================================

    private function isHtmlResponse($response): bool
    {
        if (!method_exists($response, 'headers')) {
            return false;
        }
        return str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }
}