<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = User::query()->select(['id', 'name', 'email', 'created_at']);

            if ($this->hasIsProColumn()) {
                $query->addSelect('is_pro');
            } else {
                $query->selectRaw('0 as is_pro');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('pro_badge', function (User $user): string {
                    if ($user->is_pro) {
                        return '<span class="badge bg-success">PRO</span>';
                    }

                    return '<span class="badge bg-secondary">THƯỜNG</span>';
                })
                ->addColumn('created_date', function (User $user): string {
                    return $user->created_at?->format('d/m/Y H:i') ?? '';
                })
                ->addColumn('action', function (User $user): string {
                    $edit = route('admin.content.user.edit', $user->id);
                    $del = route('admin.content.user.destroy', $user->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $buttons = '<a href="' . $edit . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ';
                    $buttons .= '<form action="' . $del . '" method="POST" style="display:inline-block; margin-left:4px;">'
                        . $csrf . $method
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn chắc chắn muốn xóa?\')"><i class="fas fa-trash"></i></button></form>';

                    return $buttons;
                })
                ->rawColumns(['pro_badge', 'action'])
                ->make(true);
        }

        return view('admin.content.user.index');
    }

    public function create(): View
    {
        return view('admin.content.user.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $hasIsProColumn = $this->hasIsProColumn();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];

        if ($hasIsProColumn) {
            $rules['is_pro'] = ['required', 'boolean'];
        }

        $data = $request->validate($rules);

        if (! $hasIsProColumn) {
            unset($data['is_pro']);
        }

        User::create($data);

        return redirect()->route('admin.content.user.index')->with('success', 'Tạo tài khoản người dùng thành công.');
    }

    public function edit(User $user): View
    {
        return view('admin.content.user.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $hasIsProColumn = $this->hasIsProColumn();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
        ];

        if ($hasIsProColumn) {
            $rules['is_pro'] = ['required', 'boolean'];
        }

        $data = $request->validate($rules);

        if (blank($data['password'])) {
            unset($data['password']);
        }

        if (! $hasIsProColumn) {
            unset($data['is_pro']);
        }

        $user->update($data);

        return redirect()->route('admin.content.user.index')->with('success', 'Cập nhật tài khoản người dùng thành công.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.content.user.index')->with('success', 'Xóa tài khoản người dùng thành công.');
    }

    private function hasIsProColumn(): bool
    {
        static $hasColumn;

        if ($hasColumn === null) {
            $hasColumn = Schema::hasColumn('users', 'is_pro');
        }

        return $hasColumn;
    }
}
