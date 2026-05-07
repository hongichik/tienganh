<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kỹ năng viết</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --line: #e5e7eb;
            --badge: #0f766e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 10%, rgba(2, 132, 199, 0.08), transparent 28%),
                radial-gradient(circle at 90% 90%, rgba(234, 88, 12, 0.08), transparent 28%),
                var(--bg);
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            width: min(1100px, 100%);
            margin: 0 auto;
            animation: appear 0.5s ease;
        }

        .head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }

        .head h1 {
            margin: 0;
            font-size: clamp(28px, 4vw, 40px);
        }

        .home-link {
            text-decoration: none;
            color: #0ea5e9;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
        }

        .block {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.05);
        }

        .block-link {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .block-link:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 26px rgba(2, 6, 23, 0.1);
        }

        .block h2 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: var(--badge);
            border-radius: 999px;
            padding: 5px 10px;
            margin-bottom: 10px;
        }

        .block p {
            margin: 0;
            color: var(--muted);
            line-height: 1.5;
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<main class="container">
    <header class="head">
        <h1>Kỹ năng Viết</h1>
        <a class="home-link" href="{{ route('user.home') }}">Quay lại trang chủ</a>
    </header>

    <section class="grid">
        <a class="block block-link" href="{{ route('user.writing.part1') }}">
            <span class="badge">KHỐI 1</span>
            <h2>Part 1</h2>
            <p>Luyện câu cơ bản, sử dụng từ vựng cơ bản và cấu trúc ngắn.</p>
        </a>

        <article class="block">
            <span class="badge">KHỐI 2</span>
            <h2>Part 2</h2>
            <p>Luyện mô tả và viết đoạn ngắn theo chủ đề đã cho.</p>
        </article>

        <article class="block">
            <span class="badge">KHỐI 3</span>
            <h2>Part 3</h2>
            <p>Phát triển ý và liên kết câu bằng từ nối phù hợp.</p>
        </article>

        <article class="block">
            <span class="badge">KHỐI 4</span>
            <h2>Part 4</h2>
            <p>Viết bài hoàn chỉnh, chú ý bố cục, ngữ pháp và logic trình bày.</p>
        </article>

        <article class="block">
            <span class="badge">KHỐI 5</span>
            <h2>Từ mới</h2>
            <p>Tổng hợp từ vựng cần nhớ theo chủ đề và các mẫu câu ứng dụng.</p>
        </article>
    </section>
</main>
</body>
</html>