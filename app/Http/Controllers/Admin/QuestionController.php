<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        if ($request->ajax()) {
            $query = Question::query()->select(['id', 'question', 'type', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('question_text', function (Question $question): string {
                    return \Illuminate\Support\Str::limit($question->question, 140);
                })
                ->addColumn('type_badge', function (Question $question): string {
                    return '<span class="badge bg-info">' . e(strtoupper($question->type)) . '</span>';
                })
                ->addColumn('created_date', function (Question $question): string {
                    return $question->created_at?->format('d/m/Y H:i') ?? '';
                })
                ->addColumn('action', function (Question $question): string {
                    $edit = route('admin.content.question.edit', $question->id);
                    $del = route('admin.content.question.destroy', $question->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $btns = '<a href="' . $edit . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $btns .= '<form action="' . $del . '" method="POST" style="display:inline-block; margin-left:4px;">'
                        . $csrf . $method
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn chắc chắn muốn xóa?\')"><i class="fas fa-trash"></i></button></form>';

                    return $btns;
                })
                ->rawColumns(['type_badge', 'action'])
                ->make(true);
        }

        return view('admin.content.question.index');
    }

    public function create(): View
    {
        $types = ['viet1', 'viet2', 'viet3', 'viet4'];

        return view('admin.content.question.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question' => ['required', 'string'],
            'type' => ['required', 'in:viet1,viet2,viet3,viet4'],
            'chat_prompt_1' => ['nullable', 'string'],
            'chat_prompt_2' => ['nullable', 'string'],
            'chat_prompt_3' => ['nullable', 'string'],
        ]);

        if ($data['type'] === 'viet3') {
            $chatPrompts = [
                trim((string) ($data['chat_prompt_1'] ?? '')),
                trim((string) ($data['chat_prompt_2'] ?? '')),
                trim((string) ($data['chat_prompt_3'] ?? '')),
            ];

            if (collect($chatPrompts)->filter()->count() !== 3) {
                return back()
                    ->withErrors(['chat_prompt_1' => 'Với VIET3, bạn cần nhập đủ 3 phần chat.'])
                    ->withInput();
            }

            $data['meta'] = [
                'chat_prompts' => $chatPrompts,
            ];
        }

        unset($data['chat_prompt_1'], $data['chat_prompt_2'], $data['chat_prompt_3']);

        Question::create($data);

        return redirect()->route('admin.content.question.index')->with('success', 'Tạo câu hỏi thành công.');
    }

    public function edit(Question $question): View
    {
        $types = ['viet1', 'viet2', 'viet3', 'viet4'];

        return view('admin.content.question.edit', compact('question', 'types'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $data = $request->validate([
            'question' => ['required', 'string'],
            'type' => ['required', 'in:viet1,viet2,viet3,viet4'],
            'chat_prompt_1' => ['nullable', 'string'],
            'chat_prompt_2' => ['nullable', 'string'],
            'chat_prompt_3' => ['nullable', 'string'],
        ]);

        if ($data['type'] === 'viet3') {
            $chatPrompts = [
                trim((string) ($data['chat_prompt_1'] ?? '')),
                trim((string) ($data['chat_prompt_2'] ?? '')),
                trim((string) ($data['chat_prompt_3'] ?? '')),
            ];

            if (collect($chatPrompts)->filter()->count() !== 3) {
                return back()
                    ->withErrors(['chat_prompt_1' => 'Với VIET3, bạn cần nhập đủ 3 phần chat.'])
                    ->withInput();
            }

            $data['meta'] = [
                'chat_prompts' => $chatPrompts,
            ];
        } else {
            $data['meta'] = null;
        }

        unset($data['chat_prompt_1'], $data['chat_prompt_2'], $data['chat_prompt_3']);

        $question->update($data);

        return redirect()->route('admin.content.question.index')->with('success', 'Cập nhật câu hỏi thành công.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.content.question.index')->with('success', 'Xóa câu hỏi thành công.');
    }
}
