<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyen Part 3</title>
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
            --accent-a: #0891b2;
            --accent-b: #0f766e;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 10%, rgba(8, 145, 178, 0.1), transparent 30%),
                radial-gradient(circle at 90% 90%, rgba(15, 118, 110, 0.1), transparent 30%),
                var(--bg);
            padding: 24px;
        }

        .container {
            width: min(980px, 100%);
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
            color: #155e75;
        }

        .question {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.5;
            margin: 10px 0 16px;
            white-space: pre-line;
        }

        .chat-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 10px;
        }

        .step-note {
            margin: 10px 0 16px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            color: #115e59;
            font-weight: 600;
        }

        .chat-item {
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 12px;
            background: #f8fafc;
        }

        .chat-item strong {
            display: inline-block;
            margin-bottom: 6px;
            color: #0f766e;
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

        textarea,
        input[type="text"] {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 15px;
            font-family: inherit;
            line-height: 1.5;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
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
        <h1>Luyen Part 3</h1>
        <a class="back-link" href="{{ route('user.writing') }}">Quay lai trang viet</a>
    </div>

    <div class="panel">
        @if ($question === null)
            <div class="done">
                <h2>Hoan thanh!</h2>
                <p>Ban da di het danh sach cau hoi Part 3.</p>
                <form method="POST" action="{{ route('user.writing.part3.restart') }}">
                    @csrf
                    <button class="btn-main" type="submit">Lam lai voi thu tu moi</button>
                </form>
            </div>
        @else
            <div class="meta">
                <span class="badge">Part 3 · Con {{ $remainingCount }} / {{ $totalCount }} cau</span>
                <form method="POST" action="{{ route('user.writing.part3.restart') }}">
                    @csrf
                    <button type="submit" class="btn-sub">Bat dau lai</button>
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

            <div class="step-note">Dang tra loi phan {{ $activeStep }} / 3. Hoan thanh phan hien tai de mo phan tiep theo.</div>

            <div class="chat-grid">
                @foreach ($chatPrompts as $index => $chatPrompt)
                    @if (($index + 1) === $activeStep)
                    <div class="chat-item">
                        <strong>Chat {{ $index + 1 }} (dang lam)</strong>
                        <div>{{ $chatPrompt }}</div>
                    </div>
                    @endif
                @endforeach
            </div>

            @if($showHint)
                <div class="hint">{{ $hintText }}</div>
            @endif

            <form method="POST" action="{{ route('user.writing.part3.answer') }}">
                @csrf

                <label for="answer">Tra loi phan {{ $activeStep }}</label>
                <textarea id="answer" name="answer" required autofocus>{{ $answerValue }}</textarea>

                <div class="actions">
                    <button class="btn-main" type="submit">Tra loi</button>
                    <a class="btn-link btn-sub" href="{{ route('user.writing.part3', ['show_hint' => 1]) }}">Goi y</a>
                </div>
            </form>

            <form method="POST" action="{{ route('user.writing.part3.personal-hint') }}" style="margin-top: 14px;">
                @csrf
                <label for="hint">Them goi y ca nhan cho phan {{ $activeStep }}</label>
                <input id="hint" name="hint" type="text" value="{{ $personalHintValue }}" placeholder="Vi du: dung cau truc y kien + ly do" required>
                <div class="actions">
                    <button class="btn-sub" type="submit">Luu goi y ca nhan</button>
                </div>
            </form>
        @endif
    </div>
</div>
@if (session('part3_alert_hint'))
<script>
window.addEventListener('DOMContentLoaded', function () {
    alert(@json(session('part3_alert_hint')));
});
</script>
@endif
</body>
</html>
