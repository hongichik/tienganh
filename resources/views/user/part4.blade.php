<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyen Part 4</title>
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
            --accent-a: #0f766e;
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
                radial-gradient(circle at 90% 90%, rgba(15, 118, 110, 0.08), transparent 30%),
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

        .prompt {
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 14px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .task {
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
            background: #ffffff;
        }

        .task h3 {
            margin: 0 0 6px;
            font-size: 18px;
        }

        .task p {
            margin: 0;
            color: #334155;
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

        label {
            display: block;
            margin: 10px 0 6px;
            font-weight: 600;
        }

        textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 15px;
            font-family: inherit;
            line-height: 1.6;
            resize: vertical;
        }

        .w-1 { min-height: 130px; }
        .w-2 { min-height: 240px; }

        .word-hint {
            margin-top: 6px;
            color: #64748b;
            font-size: 13px;
        }

        .actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button {
            border: 0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
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

        .error-note {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1>Luyen Part 4</h1>
        <a class="back-link" href="{{ route('user.writing') }}">Quay lai trang viet</a>
    </div>

    <div class="panel">
        @if ($question === null)
            <div class="done">
                <h2>Hoan thanh!</h2>
                <p>Ban da di het danh sach de Part 4.</p>
                <form method="POST" action="{{ route('user.writing.part4.restart') }}">
                    @csrf
                    <button class="btn-main" type="submit">Lam lai voi thu tu moi</button>
                </form>
            </div>
        @else
            <div class="meta">
                <span class="badge">Part 4 · Con {{ $remainingCount }} / {{ $totalCount }} de</span>
                <form method="POST" action="{{ route('user.writing.part4.restart') }}">
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

            <h2 style="margin: 0 0 10px;">{{ $question->question }}</h2>

            <div class="prompt">{{ $introTitle }}
{{ $introBody }}

{{ $introSignature }}</div>

            <div class="task">
                <h3>Phan 1</h3>
                <p>{{ $taskOneInstruction }}</p>
            </div>

            <div class="task">
                <h3>Phan 2</h3>
                <p>{{ $taskTwoInstruction }}</p>
            </div>

            <form method="POST" action="{{ route('user.writing.part4.answer') }}">
                @csrf

                <label for="answer_1">Bai viet phan 1</label>
                <textarea id="answer_1" name="answer_1" class="w-1" required>{{ $answerOneValue }}</textarea>
                <div class="word-hint">Goi y do dai: khoang 50 tu (khuyen nghi 40-70 tu). Tu hien tai: <span id="count_1">0</span></div>
                @error('answer_1')<div class="error-note">{{ $message }}</div>@enderror

                <label for="answer_2">Bai viet phan 2</label>
                <textarea id="answer_2" name="answer_2" class="w-2" required>{{ $answerTwoValue }}</textarea>
                <div class="word-hint">Yeu cau do dai: 120-150 tu. Tu hien tai: <span id="count_2">0</span></div>
                @error('answer_2')<div class="error-note">{{ $message }}</div>@enderror

                <div class="actions">
                    <button class="btn-main" type="submit">Nop bai va sang de tiep</button>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
function countWords(value) {
    const clean = value.trim().replace(/\s+/g, ' ');
    if (!clean) {
        return 0;
    }
    return clean.split(' ').length;
}

function bindCounter(textareaId, countId) {
    const textarea = document.getElementById(textareaId);
    const count = document.getElementById(countId);
    if (!textarea || !count) {
        return;
    }

    const update = () => {
        count.textContent = countWords(textarea.value);
    };

    textarea.addEventListener('input', update);
    update();
}

bindCounter('answer_1', 'count_1');
bindCounter('answer_2', 'count_2');
</script>
</body>
</html>
