<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class VocabularyLearningController extends Controller
{
    public function show(Request $request): View
    {
        $mode = $this->resolveMode($request->query('mode'));
        $question = $this->randomQuestion();

        if (! $question) {
            return view('user.vocabulary', [
                'mode' => $mode,
                'question' => null,
                'options' => collect(),
                'feedbackStatus' => session('vocab_feedback_status'),
                'feedbackMessage' => session('vocab_feedback_message'),
                'answerValue' => old('answer', ''),
            ]);
        }

        return view('user.vocabulary', [
            'mode' => $mode,
            'question' => $question,
            'options' => $mode === 'mode1' ? $this->buildModeOneOptions($question) : collect(),
            'feedbackStatus' => session('vocab_feedback_status'),
            'feedbackMessage' => session('vocab_feedback_message'),
            'answerValue' => old('answer', ''),
        ]);
    }

    public function submitModeOne(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vocabulary_id' => ['required', 'integer', 'exists:vocabularies,id'],
            'selected_answer' => ['required', 'string'],
        ]);

        $question = Vocabulary::query()->findOrFail((int) $data['vocabulary_id']);

        $correctAnswer = (string) $question->vietnamese_word;
        $isCorrect = $this->normalize((string) $data['selected_answer']) === $this->normalize($correctAnswer);

        return redirect()->route('user.writing.vocabulary', ['mode' => 'mode1'])
            ->with('vocab_feedback_status', $isCorrect ? 'correct' : 'wrong')
            ->with('vocab_feedback_message', $isCorrect
                ? 'Đúng rồi!'
                : 'Sai rồi. Câu hỏi: ' . $question->english_word . ' | Đáp án đúng: ' . $correctAnswer);
    }

    public function submitModeTwo(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vocabulary_id' => ['required', 'integer', 'exists:vocabularies,id'],
            'answer' => ['required', 'string'],
        ]);

        $question = Vocabulary::query()->findOrFail((int) $data['vocabulary_id']);

        $correctAnswer = (string) $question->english_word;
        $isCorrect = $this->normalize((string) $data['answer']) === $this->normalize($correctAnswer);

        return redirect()->route('user.writing.vocabulary', ['mode' => 'mode2'])
            ->with('vocab_feedback_status', $isCorrect ? 'correct' : 'wrong')
            ->with('vocab_feedback_message', $isCorrect
                ? 'Đúng rồi!'
                : 'Sai rồi. Câu hỏi: ' . $question->vietnamese_word . ' | Đáp án đúng: ' . $correctAnswer);
    }

    private function randomQuestion(): ?Vocabulary
    {
        return Vocabulary::query()
            ->whereNotNull('english_word')
            ->where('english_word', '!=', '')
            ->whereNotNull('vietnamese_word')
            ->where('vietnamese_word', '!=', '')
            ->inRandomOrder()
            ->first();
    }

    private function buildModeOneOptions(Vocabulary $question): Collection
    {
        $correctAnswer = trim((string) $question->vietnamese_word);

        $otherAnswers = Vocabulary::query()
            ->where('id', '!=', $question->id)
            ->whereNotNull('vietnamese_word')
            ->where('vietnamese_word', '!=', '')
            ->inRandomOrder()
            ->limit(20)
            ->pluck('vietnamese_word')
            ->map(fn (string $value): string => trim($value))
            ->filter()
            ->unique()
            ->take(4);

        return collect([$correctAnswer])
            ->merge($otherAnswers)
            ->unique()
            ->shuffle()
            ->values();
    }

    private function resolveMode(?string $mode): string
    {
        return in_array($mode, ['mode1', 'mode2'], true) ? $mode : 'mode1';
    }

    private function normalize(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return trim($value);
    }
}
