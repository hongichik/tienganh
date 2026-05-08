<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PartFourController extends Controller
{
    private const PART_FOUR_TYPE = 'viet4';

    public function show(Request $request): View
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return view('user.part4', [
                'question' => null,
                'remainingCount' => 0,
                'totalCount' => 0,
                'feedbackStatus' => session('part4_feedback_status'),
                'feedbackMessage' => session('part4_feedback_message'),
                'answerOneValue' => '',
                'answerTwoValue' => '',
                'taskOneInstruction' => '',
                'taskTwoInstruction' => '',
                'introTitle' => 'Dear members,',
                'introBody' => '',
                'introSignature' => '',
            ]);
        }

        $question = Question::query()->findOrFail((int) $queue->first());
        $meta = is_array($question->meta) ? $question->meta : [];

        $userAnswers = Answer::query()
            ->where('question_id', (int) $question->id)
            ->where('user_id', (int) $request->user()->id)
            ->whereIn('answer_position', [1, 2])
            ->orderByDesc('updated_at')
            ->get()
            ->unique('answer_position')
            ->keyBy('answer_position');

        return view('user.part4', [
            'question' => $question,
            'remainingCount' => $queue->count(),
            'totalCount' => (int) session($this->queueTotalSessionKey($request), $queue->count()),
            'feedbackStatus' => session('part4_feedback_status'),
            'feedbackMessage' => session('part4_feedback_message'),
            'answerOneValue' => old('answer_1', (string) ($userAnswers->get(1)?->content ?? '')),
            'answerTwoValue' => old('answer_2', (string) ($userAnswers->get(2)?->content ?? '')),
            'taskOneInstruction' => (string) ($meta['task_1_instruction'] ?? 'Write an email to your friend in about 50 words.'),
            'taskTwoInstruction' => (string) ($meta['task_2_instruction'] ?? 'Write an email to the manager in about 120-150 words.'),
            'introTitle' => (string) ($meta['intro_title'] ?? 'Dear members,'),
            'introBody' => (string) ($meta['intro_body'] ?? ''),
            'introSignature' => (string) ($meta['intro_signature'] ?? ''),
        ]);
    }

    public function submitAnswer(Request $request): RedirectResponse
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return redirect()->route('user.writing.part4');
        }

        $data = $request->validate([
            'answer_1' => ['required', 'string'],
            'answer_2' => ['required', 'string'],
        ]);

        $wordCountOne = $this->countWords($data['answer_1']);
        $wordCountTwo = $this->countWords($data['answer_2']);

        $errors = [];
        if ($wordCountOne < 40 || $wordCountOne > 70) {
            $errors['answer_1'] = 'Phần 1 nên khoảng 50 từ (gợi ý: 40-70 từ). Hiện tại: ' . $wordCountOne . ' từ.';
        }

        if ($wordCountTwo < 120 || $wordCountTwo > 150) {
            $errors['answer_2'] = 'Phần 2 cần 120-150 từ. Hiện tại: ' . $wordCountTwo . ' từ.';
        }

        if (! empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $questionId = (int) $queue->first();

        Answer::query()->updateOrCreate(
            [
                'question_id' => $questionId,
                'user_id' => (int) $request->user()->id,
                'answer_position' => 1,
            ],
            [
                'content' => trim($data['answer_1']),
            ]
        );

        Answer::query()->updateOrCreate(
            [
                'question_id' => $questionId,
                'user_id' => (int) $request->user()->id,
                'answer_position' => 2,
            ],
            [
                'content' => trim($data['answer_2']),
            ]
        );

        $queue->shift();
        session([$this->queueSessionKey($request) => $queue->values()->all()]);

        return redirect()->route('user.writing.part4')
            ->with('part4_feedback_status', 'correct')
            ->with('part4_feedback_message', 'Đã lưu bài viết Part 4 và chuyển sang đề tiếp theo.');
    }

    public function restart(Request $request): RedirectResponse
    {
        session()->forget($this->queueSessionKey($request));
        session()->forget($this->queueTotalSessionKey($request));

        return redirect()->route('user.writing.part4')
            ->with('part4_feedback_status', 'info')
            ->with('part4_feedback_message', 'Đã bắt đầu lại Part 4 với thứ tự ngẫu nhiên mới.');
    }

    private function getOrInitializeQueue(Request $request): Collection
    {
        $sessionKey = $this->queueSessionKey($request);
        $totalSessionKey = $this->queueTotalSessionKey($request);
        $existing = collect(session($sessionKey, []))->map(fn ($id): int => (int) $id)->filter();
        $currentTotal = (int) Question::query()->where('type', self::PART_FOUR_TYPE)->count();
        $storedTotal = (int) session($totalSessionKey, 0);

        if ($existing->isNotEmpty() && $storedTotal === $currentTotal) {
            return $existing->values();
        }

        $ids = Question::query()
            ->where('type', self::PART_FOUR_TYPE)
            ->inRandomOrder()
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->values();

        session([$sessionKey => $ids->all()]);
        session([$totalSessionKey => $ids->count()]);

        return $ids;
    }

    private function queueSessionKey(Request $request): string
    {
        return 'part4_queue_user_' . (int) $request->user()->id;
    }

    private function queueTotalSessionKey(Request $request): string
    {
        return 'part4_total_user_' . (int) $request->user()->id;
    }

    private function countWords(string $text): int
    {
        $normalized = trim(preg_replace('/\s+/u', ' ', strip_tags($text)) ?? '');
        if ($normalized === '') {
            return 0;
        }

        return count(explode(' ', $normalized));
    }
}
