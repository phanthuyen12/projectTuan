<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #f5f7fb;
            color: #182230;
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            width: min(420px, calc(100vw - 32px));
            background: #ffffff;
            border: 1px solid #d9e0ea;
            border-radius: 8px;
            padding: 28px;
            box-shadow: 0 16px 45px rgba(24, 34, 48, 0.08);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 24px;
        }

        p {
            margin: 0 0 24px;
            color: #667085;
            line-height: 1.45;
        }

        label {
            display: block;
            margin: 16px 0 8px;
            font-weight: 700;
            font-size: 14px;
        }

        input {
            width: 100%;
            min-height: 44px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 15px;
        }

        button {
            width: 100%;
            min-height: 46px;
            margin-top: 22px;
            border: 0;
            border-radius: 6px;
            background: #1769aa;
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
        }

        .error {
            margin: 12px 0 0;
            color: #b42318;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <main>
        <h1>Secure Login</h1>
        <p>Dang nhap se tao mot yeu cau duyet tu admin truoc khi vao trang tiep theo.</p>

        <form method="POST" action="{{ route('secure-login.submit') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Mat khau</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Gui yeu cau duyet</button>
        </form>
    </main>
</body>

</html>
