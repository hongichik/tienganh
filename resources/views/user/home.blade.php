<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Chọn kỹ năng</title>
    <style>
        :root {
            --bg-start: #fff7ed;
            --bg-end: #f0f9ff;
            --card-bg: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --accent: #ea580c;
            --accent-2: #0284c7;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background: radial-gradient(circle at top left, var(--bg-start), transparent 35%),
                        radial-gradient(circle at bottom right, var(--bg-end), transparent 35%),
                        #f8fafc;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .wrapper {
            width: min(900px, 100%);
            animation: fade-in 0.6s ease;
        }

        .title {
            margin: 0 0 8px;
            font-size: clamp(28px, 4vw, 42px);
        }

        .subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            display: block;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .card-link:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
            border-color: #cbd5e1;
        }

        .card h2 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.5;
        }

        .card-disabled {
            opacity: 0.88;
            cursor: not-allowed;
        }

        .status {
            display: inline-block;
            margin-top: 14px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .status-muted {
            background: #f3f4f6;
            color: #6b7280;
        }

        .status-active {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
        }

        @keyframes fade-in {
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
<main class="wrapper">
    <h1 class="title">Chọn kỹ năng học</h1>
    <p class="subtitle">Bạn có thể chọn kỹ năng Nói hoặc Viết để bắt đầu.</p>

    <section class="grid">
        <a class="card card-disabled" href="#" onclick="return false;" aria-disabled="true">
            <h2>Kỹ năng Nói</h2>
            <p>Dành cho luyện phát âm và phản xạ. Hiện tại khối này chưa mở trang mới.</p>
            <span class="status status-muted">Sắp mở</span>
        </a>

        <a class="card card-link" href="{{ route('user.writing') }}">
            <h2>Kỹ năng Viết</h2>
            <p>Mở trang bài học viết gồm 5 khối: Part 1, 2, 3, 4 và Từ mới.</p>
        </a>
    </section>
</main>
</body>
</html>