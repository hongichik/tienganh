<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserQuestionHint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PartOneController extends Controller
{
    private const PART_ONE_TYPE = 'viet1';
    private const BASE_HINT_POSITION = 0;

    public function show(Request $request): View
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return view('user.part1', [
                'question' => null,
                'remainingCount' => 0,
                'totalCount' => 0,
                'showHint' => false,
                'hintText' => null,
                'feedbackStatus' => session('part1_feedback_status'),
                'feedbackMessage' => session('part1_feedback_message'),
                'answerValue' => '',
                'personalHintValue' => '',
            ]);
        }

        $question = Question::query()->with('answers')->findOrFail((int) $queue->first());
        $personalHint = UserQuestionHint::query()
            ->where('user_id', (int) $request->user()->id)
            ->where('question_id', (int) $question->id)
            ->where('answer_position', self::BASE_HINT_POSITION)
            ->first();

        $showHint = $request->boolean('show_hint');
        $hintText = null;

        if ($showHint) {
            if ($personalHint !== null) {
                $hintText = 'Gợi ý cá nhân: ' . $personalHint->hint;
            } else {
                $commonHint = $question->answers
                    ->whereNull('user_id')
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->first();

                $hintText = $commonHint ? ('Gợi ý chung: ' . $commonHint) : 'Hiện chưa có gợi ý chung.';
            }
        }

        return view('user.part1', [
            'question' => $question,
            'remainingCount' => $queue->count(),
            'totalCount' => (int) session($this->queueTotalSessionKey($request), $queue->count()),
            'showHint' => $showHint,
            'hintText' => $hintText,
            'feedbackStatus' => session('part1_feedback_status'),
            'feedbackMessage' => session('part1_feedback_message'),
            'answerValue' => old('answer', ''),
            'personalHintValue' => $personalHint?->hint ?? '',
        ]);
    }

    public function submitAnswer(Request $request): RedirectResponse
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return redirect()->route('user.writing.part1');
        }

        $data = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $questionId = (int) $queue->first();
        $question = Question::query()->with('answers')->findOrFail($questionId);

        $acceptedAnswers = $question->answers
            ->pluck('content')
            ->filter()
            ->map(fn (string $value): string => $this->normalizeAnswer($value));

        $personalHint = UserQuestionHint::query()
            ->where('user_id', (int) $request->user()->id)
            ->where('question_id', $questionId)
            ->where('answer_position', self::BASE_HINT_POSITION)
            ->value('hint');

        if ($personalHint) {
            $acceptedAnswers->push($this->normalizeAnswer($personalHint));
        }

        $submittedAnswer = $this->normalizeAnswer($data['answer']);
        $isCorrect = $acceptedAnswers->contains($submittedAnswer);

        $hintForWrongAnswer = null;
        if (! $isCorrect) {
            $hintForWrongAnswer = $personalHint;

            if (! $hintForWrongAnswer) {
                $hintForWrongAnswer = $question->answers
                    ->whereNull('user_id')
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->first();
            }
        }

        $queue->shift();

        if (! $isCorrect) {
            $queue->push($questionId);
        }

        session([$this->queueSessionKey($request) => $queue->values()->all()]);

        $redirect = redirect()->route('user.writing.part1')
            ->with('part1_feedback_status', $isCorrect ? 'correct' : 'wrong')
            ->with('part1_feedback_message', $isCorrect ? 'Đúng rồi!' : 'Sai rồi, câu này sẽ được hỏi lại sau.');

        if (! $isCorrect) {
            $redirect->with(
                'part1_alert_hint',
                'Sai rồi. Gợi ý: ' . ($hintForWrongAnswer ?: 'Hiện chưa có gợi ý cho câu này.')
            );
        }

        return $redirect;
    }

    public function savePersonalHint(Request $request): RedirectResponse
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return redirect()->route('user.writing.part1');
        }

        $data = $request->validate([
            'hint' => ['required', 'string', 'max:255'],
        ]);

        $questionId = (int) $queue->first();

        UserQuestionHint::query()->updateOrCreate(
            [
                'user_id' => (int) $request->user()->id,
                'question_id' => $questionId,
                'answer_position' => self::BASE_HINT_POSITION,
            ],
            [
                'hint' => trim($data['hint']),
            ]
        );

        return redirect()->route('user.writing.part1', ['show_hint' => 1])
            ->with('part1_feedback_status', 'info')
            ->with('part1_feedback_message', 'Đã lưu gợi ý cá nhân. Từ giờ sẽ ưu tiên gợi ý cá nhân cho câu này.');
    }

    public function restart(Request $request): RedirectResponse
    {
        session()->forget($this->queueSessionKey($request));
        session()->forget($this->queueTotalSessionKey($request));

        return redirect()->route('user.writing.part1')
            ->with('part1_feedback_status', 'info')
            ->with('part1_feedback_message', 'Đã bắt đầu lại Part 1 với thứ tự ngẫu nhiên mới.');
    }

    private function getOrInitializeQueue(Request $request): Collection
    {
        $sessionKey = $this->queueSessionKey($request);
        $existing = collect(session($sessionKey, []))->map(fn ($id): int => (int) $id)->filter();

        if ($existing->isNotEmpty()) {
            return $existing->values();
        }

        $ids = Question::query()
            ->where('type', self::PART_ONE_TYPE)
            ->inRandomOrder()
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->values();

        session([$sessionKey => $ids->all()]);
        session([$this->queueTotalSessionKey($request) => $ids->count()]);

        return $ids;
    }

    private function queueSessionKey(Request $request): string
    {
        return 'part1_queue_user_' . (int) $request->user()->id;
    }

    private function queueTotalSessionKey(Request $request): string
    {
        return 'part1_total_user_' . (int) $request->user()->id;
    }

    private function normalizeAnswer(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;
        $value = preg_replace('/[\.,!?;:]+$/u', '', $value) ?? $value;

        return trim($value);
    }
}
