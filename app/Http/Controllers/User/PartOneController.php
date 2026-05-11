<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AI;
use App\Models\Question;
use App\Models\UserQuestionHint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PartOneController extends Controller
{
    private const PART_ONE_TYPE = 'viet1';
    private const BASE_HINT_POSITION = 0;
    private const AI_QUESTION_SESSION_KEY = 'part1_ai_question_enabled';
    private const AI_ANSWER_SESSION_KEY = 'part1_ai_answer_enabled';

    public function show(Request $request): View
    {
        $queue = $this->getOrInitializeQueue($request);
        $isProUser = $this->isProUser($request);
        $aiQuestionEnabled = $this->isAiQuestionEnabled($request);
        $aiAnswerEnabled = $this->isAiAnswerEnabled($request);

        if ($queue->isEmpty()) {
            return view('user.part1', [
                'question' => null,
                'questionText' => null,
                'remainingCount' => 0,
                'totalCount' => 0,
                'showHint' => false,
                'hintText' => null,
                'feedbackStatus' => session('part1_feedback_status'),
                'feedbackMessage' => session('part1_feedback_message'),
                'answerValue' => '',
                'personalHintValue' => '',
                'isProUser' => $isProUser,
                'aiQuestionEnabled' => $aiQuestionEnabled,
                'aiAnswerEnabled' => $aiAnswerEnabled,
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

        Log::info('part1.question_display_point', [
            'user_id' => (int) $request->user()->id,
            'question_id' => (int) $question->id,
            'ai_question_enabled' => $aiQuestionEnabled,
            'note' => 'Day la diem hien thi cau hoi Part 1 de sua logic.',
        ]);

        $questionText = $question->question;

        if ($aiQuestionEnabled) {
            Log::info('part1.ai_question_hook', [
                'user_id' => (int) $request->user()->id,
                'question_id' => (int) $question->id,
                'original_question' => (string) $question->question,
                'note' => 'Sua hook AI sinh cau hoi tai day neu can.',
            ]);

            $questionText = $this->resolveAiQuestionText($request, $question);
        }

        return view('user.part1', [
            'question' => $question,
            'questionText' => $questionText,
            'remainingCount' => $queue->count(),
            'totalCount' => (int) session($this->queueTotalSessionKey($request), $queue->count()),
            'showHint' => $showHint,
            'hintText' => $hintText,
            'feedbackStatus' => session('part1_feedback_status'),
            'feedbackMessage' => session('part1_feedback_message'),
            'answerValue' => old('answer', ''),
            'personalHintValue' => $personalHint?->hint ?? '',
            'isProUser' => $isProUser,
            'aiQuestionEnabled' => $aiQuestionEnabled,
            'aiAnswerEnabled' => $aiAnswerEnabled,
        ]);
    }

    public function updateAiSettings(Request $request): RedirectResponse
    {
        $isProUser = $this->isProUser($request);

        $data = $request->validate([
            'ai_question_enabled' => ['nullable', 'boolean'],
            'ai_answer_enabled' => ['nullable', 'boolean'],
        ]);

        $aiQuestionEnabled = (bool) ($data['ai_question_enabled'] ?? false);
        $aiAnswerEnabled = (bool) ($data['ai_answer_enabled'] ?? false);

        if (! $isProUser) {
            session([
                $this->aiQuestionSessionKey($request) => false,
                $this->aiAnswerSessionKey($request) => false,
            ]);

            return redirect()->route('user.writing.part1')
                ->with('part1_feedback_status', 'info')
                ->with('part1_feedback_message', 'Chỉ tài khoản Pro mới có thể bật tính năng AI.');
        }

        session([
            $this->aiQuestionSessionKey($request) => $aiQuestionEnabled,
            $this->aiAnswerSessionKey($request) => $aiAnswerEnabled,
        ]);

        if (! $aiQuestionEnabled) {
            session()->forget($this->aiQuestionTextSessionKey($request));
        }

        return redirect()->route('user.writing.part1')
            ->with('part1_feedback_status', 'info')
            ->with('part1_feedback_message', 'Đã cập nhật chế độ AI cho Part 1.');
    }

    public function submitAnswer(Request $request): RedirectResponse
    {
        $aiAnswerEnabled = $this->isAiAnswerEnabled($request);
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
        $feedbackStatus = $isCorrect ? 'correct' : 'wrong';
        $feedbackMessage = $isCorrect ? 'Đúng rồi!' : 'Sai rồi, câu này sẽ được hỏi lại sau.';
        $aiHint = null;

        if (! $isCorrect && $aiAnswerEnabled) {
            Log::info('part1.ai_answer_hook', [
                'user_id' => (int) $request->user()->id,
                'question_id' => (int) $question->id,
                'question' => (string) $question->question,
                'submitted_answer' => (string) $data['answer'],
                'accepted_answers' => $question->answers->pluck('content')->filter()->values()->all(),
                'note' => 'Sua hook AI cham cau tra loi tai day neu can.',
            ]);

            $aiResult = AI::AIReplyPart1((string) $question->question, (string) $data['answer']);
            $aiStatus = (int) data_get($aiResult, 'trang_thai', 0);
            $aiHint = trim((string) data_get($aiResult, 'goiy', ''));

            if ($aiStatus === 1) {
                $isCorrect = true;
                $feedbackStatus = 'correct';
                $feedbackMessage = $aiHint !== '' ? $aiHint : 'Đúng rồi!';
            } elseif ($aiStatus === 2) {
                $isCorrect = false;
                $feedbackStatus = 'near';
                $feedbackMessage = $aiHint !== '' ? $aiHint : 'Gần đúng, bạn chỉnh lại một chút nhé.';
            } else {
                $isCorrect = false;
                $feedbackStatus = 'wrong';
                $feedbackMessage = $aiHint !== '' ? $aiHint : 'Sai rồi, câu này sẽ được hỏi lại sau.';
            }
        }

        $hintForWrongAnswer = null;
        if (! $isCorrect) {
            $hintForWrongAnswer = $aiHint ?: $personalHint;

            if (! $hintForWrongAnswer) {
                $hintForWrongAnswer = $question->answers
                    ->whereNull('user_id')
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->first();
            }
        }

        if ($aiAnswerEnabled) {
            // In AI answer mode, only a fully correct answer can advance to next question.
            if ($isCorrect) {
                $queue->shift();
            }
        } else {
            $queue->shift();

            if (! $isCorrect) {
                $queue->push($questionId);
            }
        }

        session([$this->queueSessionKey($request) => $queue->values()->all()]);

        $redirect = redirect()->route('user.writing.part1')
            ->with('part1_feedback_status', $feedbackStatus)
            ->with('part1_feedback_message', $feedbackMessage);

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

    private function aiQuestionSessionKey(Request $request): string
    {
        return self::AI_QUESTION_SESSION_KEY . '_user_' . (int) $request->user()->id;
    }

    private function aiAnswerSessionKey(Request $request): string
    {
        return self::AI_ANSWER_SESSION_KEY . '_user_' . (int) $request->user()->id;
    }

    private function aiQuestionTextSessionKey(Request $request): string
    {
        return 'part1_ai_question_text_user_' . (int) $request->user()->id;
    }

    private function isProUser(Request $request): bool
    {
        return (bool) ($request->user()?->is_pro ?? false);
    }

    private function isAiQuestionEnabled(Request $request): bool
    {
        return $this->isProUser($request) && (bool) session($this->aiQuestionSessionKey($request), false);
    }

    private function isAiAnswerEnabled(Request $request): bool
    {
        return $this->isProUser($request) && (bool) session($this->aiAnswerSessionKey($request), false);
    }

    private function resolveAiQuestionText(Request $request, Question $question): string
    {
        $cache = collect(session($this->aiQuestionTextSessionKey($request), []));
        $cachedQuestionText = $cache->get((string) $question->id);

        if (is_string($cachedQuestionText) && trim($cachedQuestionText) !== '') {
            return $cachedQuestionText;
        }

        $generatedQuestion = $this->generateQuestionWithAi((string) $question->question);

        if (! $generatedQuestion) {
            return (string) $question->question;
        }

        $cache->put((string) $question->id, $generatedQuestion);
        session([$this->aiQuestionTextSessionKey($request) => $cache->all()]);

        return $generatedQuestion;
    }

    private function generateQuestionWithAi(string $originalQuestion): ?string
    {
        $payload = [
            'system' => 'You rewrite short English speaking questions for A1-A2 learners. Keep the same meaning, make the sentence natural, and return JSON only with key question.',
            'user' => 'Original question: ' . $originalQuestion,
        ];

        $result = $this->callAiChat($payload);

        if (! is_array($result)) {
            return null;
        }

        $question = trim((string) ($result['question'] ?? ''));

        return $question !== '' ? $question : null;
    }

    private function evaluateAnswerWithAi(Request $request, Question $question, string $submittedAnswer): bool
    {
        $payload = [
            'system' => 'You evaluate whether a learner answer is acceptable for a simple English speaking question. Return JSON only with keys accepted and reason. accepted must be true or false.',
            'user' => [
                'question' => (string) $question->question,
                'submitted_answer' => $submittedAnswer,
                'accepted_samples' => $question->answers
                    ->pluck('content')
                    ->filter()
                    ->map(fn (string $value): string => trim($value))
                    ->values()
                    ->all(),
                'personal_hint' => UserQuestionHint::query()
                    ->where('user_id', (int) $request->user()->id)
                    ->where('question_id', (int) $question->id)
                    ->where('answer_position', self::BASE_HINT_POSITION)
                    ->value('hint'),
            ],
        ];

        $result = $this->callAiChat($payload);

        if (! is_array($result)) {
            return false;
        }

        return (bool) ($result['accepted'] ?? false);
    }

    private function callAiChat(array $payload): ?array
    {
        $apiKey = (string) config('services.part1_ai.api_key');
        $model = (string) config('services.part1_ai.model');
        $baseUrl = rtrim((string) config('services.part1_ai.base_url'), '/');
        $timeout = (int) config('services.part1_ai.timeout', 20);

        if ($apiKey === '' || $model === '' || $baseUrl === '') {
            return null;
        }

        try {
            $response = Http::timeout($timeout)
                ->withToken($apiKey)
                ->post($baseUrl . '/chat/completions', [
                    'model' => $model,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => (string) ($payload['system'] ?? '')],
                        ['role' => 'user', 'content' => is_string($payload['user'] ?? null) ? $payload['user'] : json_encode($payload['user'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)],
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('part1.ai_request_failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            $content = data_get($response->json(), 'choices.0.message.content');

            if (! is_string($content) || trim($content) === '') {
                return null;
            }

            $decoded = json_decode($content, true);

            return is_array($decoded) ? $decoded : null;
        } catch (\Throwable $exception) {
            Log::warning('part1.ai_request_exception', [
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    private function normalizeAnswer(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;
        $value = preg_replace('/[\.,!?;:]+$/u', '', $value) ?? $value;

        return trim($value);
    }
}
