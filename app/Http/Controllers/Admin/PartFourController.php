<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartFourController extends Controller
{
    private const PART_FOUR_TYPE = 'viet4';

    public function index(): View
    {
        $questions = Question::query()
            ->where('type', self::PART_FOUR_TYPE)
            ->with(['answers' => function ($query): void {
                $query->whereNull('user_id')->orderBy('answer_position');
            }])
            ->latest()
            ->paginate(15);

        return view('admin.content.part4.index', compact('questions'));
    }

    public function create(): View
    {
        return view('admin.content.part4.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePartFourData($request);

        $question = Question::query()->create([
            'type' => self::PART_FOUR_TYPE,
            'question' => trim($data['title']),
            'meta' => [
                'intro_title' => 'Dear members,',
                'intro_body' => trim($data['introduction']),
                'intro_signature' => trim($data['manager_email']),
                'task_1_instruction' => trim($data['task_one_instruction']),
                'task_2_instruction' => trim($data['task_two_instruction']),
            ],
        ]);

        $this->syncSampleAnswer($question, 1, $data['sample_answer_1'] ?? null);
        $this->syncSampleAnswer($question, 2, $data['sample_answer_2'] ?? null);

        return redirect()->route('admin.content.part4.index')->with('success', 'Tạo đề Part 4 thành công.');
    }

    public function edit(int $id): View
    {
        $question = Question::query()
            ->where('type', self::PART_FOUR_TYPE)
            ->with(['answers' => function ($query): void {
                $query->whereNull('user_id');
            }])
            ->findOrFail($id);

        return view('admin.content.part4.edit', compact('question'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $question = Question::query()
            ->where('type', self::PART_FOUR_TYPE)
            ->findOrFail($id);

        $data = $this->validatePartFourData($request);

        $question->update([
            'question' => trim($data['title']),
            'meta' => [
                'intro_title' => 'Dear members,',
                'intro_body' => trim($data['introduction']),
                'intro_signature' => trim($data['manager_email']),
                'task_1_instruction' => trim($data['task_one_instruction']),
                'task_2_instruction' => trim($data['task_two_instruction']),
            ],
        ]);

        $this->syncSampleAnswer($question, 1, $data['sample_answer_1'] ?? null);
        $this->syncSampleAnswer($question, 2, $data['sample_answer_2'] ?? null);

        return redirect()->route('admin.content.part4.index')->with('success', 'Cập nhật đề Part 4 thành công.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $question = Question::query()
            ->where('type', self::PART_FOUR_TYPE)
            ->findOrFail($id);

        $question->delete();

        return redirect()->route('admin.content.part4.index')->with('success', 'Xóa đề Part 4 thành công.');
    }

    private function validatePartFourData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'introduction' => ['required', 'string'],
            'manager_email' => ['required', 'string', 'max:255'],
            'task_one_instruction' => ['required', 'string', 'max:500'],
            'task_two_instruction' => ['required', 'string', 'max:500'],
            'sample_answer_1' => ['nullable', 'string'],
            'sample_answer_2' => ['nullable', 'string'],
        ]);
    }

    private function syncSampleAnswer(Question $question, int $position, ?string $content): void
    {
        $text = trim((string) $content);

        if ($text === '') {
            Answer::query()
                ->where('question_id', (int) $question->id)
                ->whereNull('user_id')
                ->where('answer_position', $position)
                ->delete();

            return;
        }

        Answer::query()->updateOrCreate(
            [
                'question_id' => (int) $question->id,
                'user_id' => null,
                'answer_position' => $position,
            ],
            [
                'content' => $text,
            ]
        );
    }
}
