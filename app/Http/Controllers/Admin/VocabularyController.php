<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class VocabularyController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Vocabulary::query()->select(['id', 'english_word', 'vietnamese_word', 'created_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('english_text', function (Vocabulary $vocabulary): string {
                    return e($vocabulary->english_word);
                })
                ->addColumn('vietnamese_text', function (Vocabulary $vocabulary): string {
                    return e(\Illuminate\Support\Str::limit((string) $vocabulary->vietnamese_word, 140));
                })
                ->addColumn('created_date', function (Vocabulary $vocabulary): string {
                    return $vocabulary->created_at?->format('d/m/Y H:i') ?? '';
                })
                ->addColumn('action', function (Vocabulary $vocabulary): string {
                    $edit = route('admin.content.vocabulary.edit', $vocabulary->id);
                    $del = route('admin.content.vocabulary.destroy', $vocabulary->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $buttons = '<a href="' . $edit . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $buttons .= '<form action="' . $del . '" method="POST" style="display:inline-block; margin-left:4px;">'
                        . $csrf . $method
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn chắc chắn muốn xóa?\')"><i class="fas fa-trash"></i></button></form>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.content.vocabulary.index');
    }

    public function create(): View
    {
        return view('admin.content.vocabulary.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'english_word' => ['required', 'string', 'max:255'],
            'vietnamese_word' => ['nullable', 'string'],
        ]);

        Vocabulary::create($data);

        return redirect()->route('admin.content.vocabulary.index')->with('success', 'Tạo từ vựng thành công.');
    }

    public function edit(Vocabulary $vocabulary): View
    {
        return view('admin.content.vocabulary.edit', compact('vocabulary'));
    }

    public function update(Request $request, Vocabulary $vocabulary): RedirectResponse
    {
        $data = $request->validate([
            'english_word' => ['required', 'string', 'max:255'],
            'vietnamese_word' => ['nullable', 'string'],
        ]);

        $vocabulary->update($data);

        return redirect()->route('admin.content.vocabulary.index')->with('success', 'Cập nhật từ vựng thành công.');
    }

    public function destroy(Vocabulary $vocabulary): RedirectResponse
    {
        $vocabulary->delete();

        return redirect()->route('admin.content.vocabulary.index')->with('success', 'Xóa từ vựng thành công.');
    }
}
