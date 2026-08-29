<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang cho duyet</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #ffffff;
            color: #182230;
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            width: min(460px, calc(100vw - 32px));
            text-align: center;
        }

        .spinner {
            width: 46px;
            height: 46px;
            margin: 0 auto 24px;
            border: 4px solid #d9e0ea;
            border-top-color: #1769aa;
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        p {
            margin: 0;
            color: #667085;
            line-height: 1.45;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <main>
        <div class="spinner" aria-hidden="true"></div>
        <h1>Dang cho admin duyet</h1>
        <p>Man hinh nay se tu dong chuyen trang neu yeu cau duoc chap nhan.</p>
    </main>

    <script>
        const statusUrl = @json($statusUrl);

        async function checkStatus() {
            try {
                const response = await fetch(statusUrl, {
                    headers: {
                        Accept: 'application/json'
                    }
                });
                const data = await response.json();

                if (data.status === 'approved' && data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                    return;
                }

                if (data.status === 'rejected') {
                    window.location.href = data.redirectUrl || '/invitation-login';
                    return;
                }
            } catch (error) {
                console.warn('Approval status check failed', error);
            }

            setTimeout(checkStatus, 1500);
        }

        checkStatus();
    </script>
</body>

</html>
