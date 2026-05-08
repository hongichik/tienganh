<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserQuestionHint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PartThreeController extends Controller
{
    private const PART_THREE_TYPE = 'viet3';

    public function show(Request $request): View
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            $this->resetProgress($request);

            return view('user.part3', [
                'question' => null,
                'remainingCount' => 0,
                'totalCount' => 0,
                'showHint' => false,
                'hintText' => null,
                'feedbackStatus' => session('part3_feedback_status'),
                'feedbackMessage' => session('part3_feedback_message'),
                'activeStep' => 1,
                'answerValue' => '',
                'personalHintValue' => '',
                'chatPrompts' => [],
            ]);
        }

        $question = Question::query()->with('answers')->findOrFail((int) $queue->first());
        $chatPrompts = $this->resolveChatPrompts($question);
        $activeStep = $this->getActiveStep($request, (int) $question->id);

        $personalHint = UserQuestionHint::query()
            ->where('user_id', (int) $request->user()->id)
            ->where('question_id', (int) $question->id)
            ->where('answer_position', $activeStep)
            ->first();

        $showHint = $request->boolean('show_hint');
        $hintText = null;

        if ($showHint) {
            if ($personalHint !== null) {
                $hintText = 'Goi y ca nhan (phan ' . $activeStep . '): ' . $personalHint->hint;
            } else {
                $commonHint = $question->answers
                    ->whereNull('user_id')
                    ->where('answer_position', $activeStep)
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->first();

                if (! $commonHint) {
                    $commonHint = $question->answers
                        ->whereNull('user_id')
                        ->whereNull('answer_position')
                        ->pluck('content')
                        ->filter()
                        ->map(fn (string $value): string => trim($value))
                        ->first();
                }

                $hintText = $commonHint
                    ? ('Goi y chung (phan ' . $activeStep . '): ' . $commonHint)
                    : 'Hien chua co goi y chung cho phan nay.';
            }
        }

        return view('user.part3', [
            'question' => $question,
            'remainingCount' => $queue->count(),
            'totalCount' => (int) session($this->queueTotalSessionKey($request), $queue->count()),
            'showHint' => $showHint,
            'hintText' => $hintText,
            'feedbackStatus' => session('part3_feedback_status'),
            'feedbackMessage' => session('part3_feedback_message'),
            'activeStep' => $activeStep,
            'answerValue' => old('answer', ''),
            'personalHintValue' => $personalHint?->hint ?? '',
            'chatPrompts' => $chatPrompts,
        ]);
    }

    public function submitAnswer(Request $request): RedirectResponse
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return redirect()->route('user.writing.part3');
        }

        $data = $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $questionId = (int) $queue->first();
        $question = Question::query()->with('answers')->findOrFail($questionId);
        $activeStep = $this->getActiveStep($request, $questionId);

        $acceptedAnswers = $question->answers
            ->where('answer_position', $activeStep)
            ->pluck('content')
            ->filter()
            ->map(fn (string $value): string => $this->normalizeAnswer($value));

        if ($acceptedAnswers->isEmpty()) {
            $acceptedAnswers = $question->answers
                ->whereNull('answer_position')
                ->pluck('content')
                ->filter()
                ->map(fn (string $value): string => $this->normalizeAnswer($value));
        }

        $personalHint = UserQuestionHint::query()
            ->where('user_id', (int) $request->user()->id)
            ->where('question_id', $questionId)
            ->where('answer_position', $activeStep)
            ->value('hint');

        if ($personalHint) {
            $acceptedAnswers->push($this->normalizeAnswer($personalHint));
        }

        $submittedAnswer = $this->normalizeAnswer($data['answer']);
        $isCorrect = $acceptedAnswers->contains($submittedAnswer);

        $hintForWrongAnswer = $personalHint;
        if (! $hintForWrongAnswer) {
            $hintForWrongAnswer = $question->answers
                ->whereNull('user_id')
                ->where('answer_position', $activeStep)
                ->pluck('content')
                ->filter()
                ->map(fn (string $value): string => trim($value))
                ->first();

            if (! $hintForWrongAnswer) {
                $hintForWrongAnswer = $question->answers
                    ->whereNull('user_id')
                    ->whereNull('answer_position')
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->first();
            }
        }

        if ($isCorrect) {
            if ($activeStep < 3) {
                $this->setActiveStep($request, $questionId, $activeStep + 1);

                return redirect()->route('user.writing.part3')
                    ->with('part3_feedback_status', 'correct')
                    ->with('part3_feedback_message', 'Dung roi! Da mo phan ' . ($activeStep + 1) . '.');
            }

            $queue->shift();
            session([$this->queueSessionKey($request) => $queue->values()->all()]);
            $this->resetProgress($request);

            return redirect()->route('user.writing.part3')
                ->with('part3_feedback_status', 'correct')
                ->with('part3_feedback_message', 'Dung roi! Ban da hoan thanh cau hoi nay.');
        }

        $redirect = redirect()->route('user.writing.part3')
            ->with('part3_feedback_status', 'wrong')
            ->with('part3_feedback_message', 'Sai roi, vui long thu lai phan ' . $activeStep . '.');

        $redirect->with(
            'part3_alert_hint',
            'Sai roi (phan ' . $activeStep . '). Goi y: ' . ($hintForWrongAnswer ?: 'Hien chua co goi y cho phan nay.')
        );

        return $redirect;
    }

    public function savePersonalHint(Request $request): RedirectResponse
    {
        $queue = $this->getOrInitializeQueue($request);

        if ($queue->isEmpty()) {
            return redirect()->route('user.writing.part3');
        }

        $data = $request->validate([
            'hint' => ['required', 'string', 'max:255'],
        ]);

        $questionId = (int) $queue->first();
        $activeStep = $this->getActiveStep($request, $questionId);

        UserQuestionHint::query()->updateOrCreate(
            [
                'user_id' => (int) $request->user()->id,
                'question_id' => $questionId,
                'answer_position' => $activeStep,
            ],
            [
                'hint' => trim($data['hint']),
            ]
        );

        return redirect()->route('user.writing.part3', ['show_hint' => 1])
            ->with('part3_feedback_status', 'info')
            ->with('part3_feedback_message', 'Da luu goi y ca nhan cho phan ' . $activeStep . '.');
    }

    public function restart(Request $request): RedirectResponse
    {
        session()->forget($this->queueSessionKey($request));
        session()->forget($this->queueTotalSessionKey($request));
        $this->resetProgress($request);

        return redirect()->route('user.writing.part3')
            ->with('part3_feedback_status', 'info')
            ->with('part3_feedback_message', 'Da bat dau lai Part 3 voi thu tu ngau nhien moi.');
    }

    private function getOrInitializeQueue(Request $request): Collection
    {
        $sessionKey = $this->queueSessionKey($request);
        $totalSessionKey = $this->queueTotalSessionKey($request);
        $existing = collect(session($sessionKey, []))->map(fn ($id): int => (int) $id)->filter();
        $currentTotal = (int) Question::query()->where('type', self::PART_THREE_TYPE)->count();
        $storedTotal = (int) session($totalSessionKey, 0);

        if ($existing->isNotEmpty() && $storedTotal === $currentTotal) {
            return $existing->values();
        }

        $ids = Question::query()
            ->where('type', self::PART_THREE_TYPE)
            ->inRandomOrder()
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->values();

        session([$sessionKey => $ids->all()]);
        session([$totalSessionKey => $ids->count()]);
        $this->resetProgress($request);

        return $ids;
    }

    private function queueSessionKey(Request $request): string
    {
        return 'part3_queue_user_' . (int) $request->user()->id;
    }

    private function queueTotalSessionKey(Request $request): string
    {
        return 'part3_total_user_' . (int) $request->user()->id;
    }

    private function progressSessionKey(Request $request): string
    {
        return 'part3_progress_user_' . (int) $request->user()->id;
    }

    private function getActiveStep(Request $request, int $questionId): int
    {
        $progress = session($this->progressSessionKey($request), []);
        $storedQuestionId = (int) ($progress['question_id'] ?? 0);
        $storedStep = (int) ($progress['step'] ?? 1);

        if ($storedQuestionId !== $questionId || $storedStep < 1 || $storedStep > 3) {
            $storedStep = 1;
            $this->setActiveStep($request, $questionId, $storedStep);
        }

        return $storedStep;
    }

    private function setActiveStep(Request $request, int $questionId, int $step): void
    {
        session([
            $this->progressSessionKey($request) => [
                'question_id' => $questionId,
                'step' => max(1, min(3, $step)),
            ],
        ]);
    }

    private function resetProgress(Request $request): void
    {
        session()->forget($this->progressSessionKey($request));
    }

    private function resolveChatPrompts(Question $question): array
    {
        $chatPrompts = collect(data_get($question->meta, 'chat_prompts', []))
            ->map(fn ($value): string => trim((string) $value))
            ->values()
            ->all();

        if (count($chatPrompts) < 3) {
            $chatPrompts = [
                'Kim: Please answer this chat question.',
                'Marco: Please answer this chat question.',
                'Sylvia: Please answer this chat question.',
            ];
        }

        return $chatPrompts;
    }

    private function normalizeAnswer(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;
        $value = preg_replace('/[\.,!?;:]+$/u', '', $value) ?? $value;

        return trim($value);
    }
}
