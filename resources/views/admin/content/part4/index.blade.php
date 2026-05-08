@extends('layouts.layout-master')

@section('title', 'Quản lý Part 4')
@section('page_title', 'Quản lý đề viết Part 4')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đề Part 4</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.part4.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm đề Part 4
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="70">#</th>
                            <th>Tiêu đề đề</th>
                            <th>Nội dung manager (rút gọn)</th>
                            <th width="170">Ngày tạo</th>
                            <th width="170">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ \Illuminate\Support\Str::limit((string) data_get($question->meta, 'intro_body', ''), 110) }}</td>
                                <td>{{ optional($question->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.content.part4.edit', $question->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.content.part4.destroy', $question->id) }}" method="POST" style="display:inline-block; margin-left:4px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa đề này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có đề Part 4.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($questions->hasPages())
            <div class="card-footer clearfix">
                {{ $questions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
