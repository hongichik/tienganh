<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Welcome</title>
    <style>
        :root {
            --bg-1: #fff7ed;
            --bg-2: #ecfeff;
            --bg-3: #e0f2fe;
            --text: #0f172a;
            --muted: #475569;
            --line: #cbd5e1;
            --brand-a: #ea580c;
            --brand-b: #0284c7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 8% 12%, var(--bg-1), transparent 34%),
                radial-gradient(circle at 90% 10%, var(--bg-3), transparent 32%),
                radial-gradient(circle at 90% 90%, var(--bg-2), transparent 36%),
                #f8fafc;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .card {
            width: min(980px, 100%);
            border: 1px solid var(--line);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            padding: clamp(24px, 4vw, 42px);
            animation: fade-up 0.7s ease;
        }

        .tag {
            display: inline-block;
            border: 1px solid #fed7aa;
            background: #fff7ed;
            color: #9a3412;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        h1 {
            margin: 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.05;
        }

        .grad {
            background: linear-gradient(135deg, var(--brand-a), var(--brand-b));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .desc {
            margin: 16px 0 26px;
            color: var(--muted);
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.7;
            max-width: 760px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 15px;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-main {
            color: #fff;
            background: linear-gradient(135deg, var(--brand-a), var(--brand-b));
            box-shadow: 0 10px 24px rgba(2, 132, 199, 0.3);
        }

        .btn-sub {
            color: var(--text);
            border: 1px solid var(--line);
            background: #fff;
        }

        .foot {
            margin-top: 18px;
            border-top: 1px dashed var(--line);
            padding-top: 14px;
            color: #64748b;
            font-size: 14px;
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<main class="card">
    <span class="tag">Welcome</span>
    <h1>Nền tảng học Tiếng Anh <span class="grad">gọn gàng và hiệu quả</span></h1>
    <p class="desc">
        Đây là trang duy nhất không cần đăng nhập. Tất cả các trang học phía sau đều yêu cầu đăng nhập
        trước khi truy cập.
    </p>

    <div class="actions">
        @if (auth()->check())
            <a class="btn btn-main" href="{{ route('user.home') }}">Vào trang học</a>
        @else
            <a class="btn btn-main" href="{{ route('login') }}">Đăng nhập để tiếp tục</a>
        @endif
        <a class="btn btn-sub" href="{{ route('login') }}">Mở trang đăng nhập</a>
    </div>

    <p class="foot">Trang được viết bởi HongDev.</p>
</main>
</body>
</html>
