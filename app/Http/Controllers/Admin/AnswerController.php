<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AnswerController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        if ($request->ajax()) {
            $query = Answer::query()
                ->with(['question:id,question,type', 'user:id,name,email'])
                ->select(['id', 'content', 'question_id', 'user_id', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('answer_text', function (Answer $answer): string {
                    return \Illuminate\Support\Str::limit($answer->content, 120);
                })
                ->addColumn('question_text', function (Answer $answer): string {
                    if (! $answer->question) {
                        return '-';
                    }

                    return \Illuminate\Support\Str::limit($answer->question->question, 80)
                        . ' <span class="badge bg-info">' . strtoupper($answer->question->type) . '</span>';
                })
                ->addColumn('user_text', function (Answer $answer): string {
                    if (! $answer->user) {
                        return '<span class="text-muted">Không gán user</span>';
                    }

                    return e($answer->user->name) . '<br><small class="text-muted">' . e($answer->user->email) . '</small>';
                })
                ->addColumn('created_date', function (Answer $answer): string {
                    return $answer->created_at?->format('d/m/Y H:i') ?? '';
                })
                ->addColumn('action', function (Answer $answer): string {
                    $edit = route('admin.content.answer.edit', $answer->id);
                    $del = route('admin.content.answer.destroy', $answer->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $btns = '<a href="' . $edit . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $btns .= '<form action="' . $del . '" method="POST" style="display:inline-block; margin-left:4px;">'
                        . $csrf . $method
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn chắc chắn muốn xóa?\')"><i class="fas fa-trash"></i></button></form>';

                    return $btns;
                })
                ->rawColumns(['question_text', 'user_text', 'action'])
                ->make(true);
        }

        return view('admin.content.answer.index');
    }

    public function create(): View
    {
        $questions = Question::query()->select('id', 'question', 'type')->latest()->get();
        $users = User::query()->select('id', 'name', 'email')->latest()->get();

        return view('admin.content.answer.create', compact('questions', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'question_id' => ['required', 'exists:questions,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        Answer::create($data);

        return redirect()->route('admin.content.answer.index')->with('success', 'Tạo câu trả lời thành công.');
    }

    public function edit(Answer $answer): View
    {
        $questions = Question::query()->select('id', 'question', 'type')->latest()->get();
        $users = User::query()->select('id', 'name', 'email')->latest()->get();

        return view('admin.content.answer.edit', compact('answer', 'questions', 'users'));
    }

    public function update(Request $request, Answer $answer): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'question_id' => ['required', 'exists:questions,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $answer->update($data);

        return redirect()->route('admin.content.answer.index')->with('success', 'Cập nhật câu trả lời thành công.');
    }

    public function destroy(Answer $answer): RedirectResponse
    {
        $answer->delete();

        return redirect()->route('admin.content.answer.index')->with('success', 'Xóa câu trả lời thành công.');
    }
}
