<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học từ vựng</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --line: #e5e7eb;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #0284c7;
            --correct: #16a34a;
            --wrong: #dc2626;
            --info: #0ea5e9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 15% 10%, rgba(2, 132, 199, 0.1), transparent 26%),
                radial-gradient(circle at 85% 90%, rgba(22, 163, 74, 0.1), transparent 28%),
                var(--bg);
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            width: min(900px, 100%);
            margin: 0 auto;
            animation: fadeUp 0.4s ease;
        }

        .head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .head h1 {
            margin: 0;
            font-size: clamp(26px, 4vw, 36px);
        }

        .head a {
            text-decoration: none;
            color: #0369a1;
            font-weight: 700;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 20px;
        }

        .modes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .mode-link {
            text-decoration: none;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
            font-size: 14px;
        }

        .mode-link.active {
            border-color: var(--primary);
            background: #e0f2fe;
            color: #075985;
        }

        .feedback {
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .feedback.correct {
            background: #dcfce7;
            color: var(--correct);
            border: 1px solid #86efac;
        }

        .feedback.wrong {
            background: #fee2e2;
            color: var(--wrong);
            border: 1px solid #fca5a5;
        }

        .feedback.info {
            background: #e0f2fe;
            color: var(--info);
            border: 1px solid #7dd3fc;
        }

        .label {
            color: var(--muted);
            margin: 0 0 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }

        .question {
            font-size: clamp(20px, 3vw, 28px);
            font-weight: 700;
            margin: 0 0 18px;
            line-height: 1.35;
        }

        .choices {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 10px;
            margin-bottom: 14px;
        }

        .choice-item {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            background: #f8fafc;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .choice-item input {
            margin-top: 3px;
        }

        input[type="text"] {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            padding: 10px 16px;
            cursor: pointer;
        }

        .empty {
            color: var(--muted);
            font-weight: 700;
        }

        @keyframes fadeUp {
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
        <h1>Học Từ Mới</h1>
        <a href="{{ route('user.writing') }}">Quay lại kỹ năng viết</a>
    </header>

    <section class="panel">
        <nav class="modes">
            <a class="mode-link {{ $mode === 'mode1' ? 'active' : '' }}" href="{{ route('user.writing.vocabulary', ['mode' => 'mode1']) }}">
                Lựa chọn 1: Tiếng Anh + 5 đáp án
            </a>
            <a class="mode-link {{ $mode === 'mode2' ? 'active' : '' }}" href="{{ route('user.writing.vocabulary', ['mode' => 'mode2']) }}">
                Lựa chọn 2: Tiếng Việt -> gõ tiếng Anh
            </a>
        </nav>

        @if($feedbackMessage)
            <div class="feedback {{ $feedbackStatus ?: 'info' }}">{{ $feedbackMessage }}</div>
        @endif

        @if(!$question)
            <p class="empty">Chưa có dữ liệu từ vựng để luyện. Vui lòng seed dữ liệu trước.</p>
        @elseif($mode === 'mode1')
            <p class="label">Từ tiếng Anh</p>
            <p class="question">{{ $question->english_word }}</p>

            <form method="POST" action="{{ route('user.writing.vocabulary.mode1') }}">
                @csrf
                <input type="hidden" name="vocabulary_id" value="{{ $question->id }}">

                <div class="choices">
                    @foreach($options as $option)
                        <label class="choice-item">
                            <input type="radio" name="selected_answer" value="{{ $option }}" required>
                            <span>{{ $option }}</span>
                        </label>
                    @endforeach
                </div>

                @error('selected_answer')
                    <p style="color:#dc2626; margin:0 0 10px;">{{ $message }}</p>
                @enderror

                <button class="btn" type="submit">Trả lời</button>
            </form>
        @else
            <p class="label">Nghĩa tiếng Việt</p>
            <p class="question">{{ $question->vietnamese_word }}</p>

            <form method="POST" action="{{ route('user.writing.vocabulary.mode2') }}">
                @csrf
                <input type="hidden" name="vocabulary_id" value="{{ $question->id }}">

                <input type="text" name="answer" value="{{ $answerValue }}" placeholder="Nhập từ/cụm tiếng Anh" autocomplete="off" autofocus required>

                @error('answer')
                    <p style="color:#dc2626; margin:0 0 10px;">{{ $message }}</p>
                @enderror

                <button class="btn" type="submit">Kiểm tra</button>
            </form>
        @endif
    </section>
</main>
</body>
</html>
