<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyện Part 1</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --ok: #15803d;
            --bad: #b91c1c;
            --info: #0369a1;
            --accent-a: #ea580c;
            --accent-b: #0284c7;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 10%, rgba(2, 132, 199, 0.08), transparent 30%),
                radial-gradient(circle at 90% 90%, rgba(234, 88, 12, 0.08), transparent 30%),
                var(--bg);
            padding: 24px;
        }

        .container {
            width: min(920px, 100%);
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .topbar h1 {
            margin: 0;
            font-size: clamp(26px, 4vw, 38px);
        }

        .back-link {
            color: #0369a1;
            font-weight: 700;
            text-decoration: none;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }

        .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 14px;
        }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
            background: #ecfeff;
            color: #0e7490;
        }

        .question {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.4;
            margin: 10px 0 16px;
        }

        .feedback {
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .feedback.ok { background: #dcfce7; color: var(--ok); }
        .feedback.bad { background: #fee2e2; color: var(--bad); }
        .feedback.info { background: #e0f2fe; color: var(--info); }

        .hint {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
            color: #334155;
        }

        label {
            display: block;
            margin: 10px 0 6px;
            font-weight: 600;
        }

        input[type="text"] {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 15px;
        }

        .actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button, .btn-link {
            border: 0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-main {
            color: #fff;
            background: linear-gradient(135deg, var(--accent-a), var(--accent-b));
        }

        .btn-sub {
            color: #0f172a;
            background: #e2e8f0;
        }

        .done {
            text-align: center;
            padding: 32px 20px;
        }

        .done h2 {
            margin: 0 0 8px;
            font-size: 32px;
        }

        .done p {
            color: var(--muted);
            margin: 0 0 18px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1>Luyện Part 1</h1>
        <a class="back-link" href="{{ route('user.writing') }}">Quay lại trang viết</a>
    </div>

    <div class="panel">
        @if ($question === null)
            <div class="done">
                <h2>Hoàn thành!</h2>
                <p>Bạn đã đi hết danh sách câu hỏi Part 1.</p>
                <form method="POST" action="{{ route('user.writing.part1.restart') }}">
                    @csrf
                    <button class="btn-main" type="submit">Làm lại với thứ tự mới</button>
                </form>
            </div>
        @else
            <div class="meta">
                <span class="badge">Part 1 · Còn {{ $remainingCount }} / {{ $totalCount }} câu</span>
                <form method="POST" action="{{ route('user.writing.part1.restart') }}">
                    @csrf
                    <button type="submit" class="btn-sub">Bắt đầu lại</button>
                </form>
            </div>

            @if ($feedbackStatus === 'correct')
                <div class="feedback ok">{{ $feedbackMessage }}</div>
            @elseif ($feedbackStatus === 'wrong')
                <div class="feedback bad">{{ $feedbackMessage }}</div>
            @elseif ($feedbackStatus === 'info')
                <div class="feedback info">{{ $feedbackMessage }}</div>
            @endif

            <div class="question">{{ $question->question }}</div>

            @if($showHint)
                <div class="hint">{{ $hintText }}</div>
            @endif

            <form method="POST" action="{{ route('user.writing.part1.answer') }}">
                @csrf
                <label for="answer">Nhập câu trả lời</label>
                <input id="answer" name="answer" type="text" value="{{ $answerValue }}" autocomplete="off" autofocus required>
                <div class="actions">
                    <button class="btn-main" type="submit">Trả lời</button>
                    <a class="btn-link btn-sub" href="{{ route('user.writing.part1', ['show_hint' => 1]) }}">Gợi ý</a>
                </div>
            </form>

            <form method="POST" action="{{ route('user.writing.part1.personal-hint') }}" style="margin-top: 14px;">
                @csrf
                <label for="hint">Thêm gợi ý cá nhân</label>
                <input id="hint" name="hint" type="text" value="{{ $personalHintValue }}" placeholder="Ví dụ: I like football" required>
                <div class="actions">
                    <button class="btn-sub" type="submit">Lưu gợi ý cá nhân</button>
                </div>
            </form>
        @endif
    </div>
</div>
@if (session('part1_alert_hint'))
<script>
window.addEventListener('DOMContentLoaded', function () {
    alert(@json(session('part1_alert_hint')));
});
</script>
@endif
</body>
</html>
