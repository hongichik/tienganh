<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        :root {
            --bg-a: #fff7ed;
            --bg-b: #e0f2fe;
            --panel: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #cbd5e1;
            --accent-a: #ea580c;
            --accent-b: #0284c7;
            --danger-bg: #fef2f2;
            --danger-line: #fecaca;
            --danger-text: #b91c1c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 8% 14%, var(--bg-a), transparent 35%),
                radial-gradient(circle at 92% 10%, var(--bg-b), transparent 33%),
                #f8fafc;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .panel {
            width: min(460px, 100%);
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.1);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .hint {
            margin: 0 0 18px;
            color: var(--muted);
            line-height: 1.55;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
        }

        input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #7dd3fc;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }

        .error {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--danger-line);
            background: var(--danger-bg);
            color: var(--danger-text);
            font-size: 14px;
        }

        button {
            width: 100%;
            margin-top: 16px;
            border: 0;
            border-radius: 10px;
            padding: 12px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent-a), var(--accent-b));
            cursor: pointer;
        }

        .back {
            margin-top: 12px;
            text-align: center;
        }

        .back a {
            color: #0369a1;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
<main class="panel">
    <h1>Đăng nhập</h1>
    <p class="hint">
        Nếu email chưa có tài khoản, hệ thống sẽ tự động tạo tài khoản mới và đăng nhập ngay.
    </p>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Mật khẩu</label>
        <input id="password" name="password" type="password" required>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <button type="submit">Đăng nhập / Tạo tài khoản</button>
    </form>

    <p class="back"><a href="{{ route('welcome') }}">Quay lại welcome</a></p>
</main>
</body>
</html>
