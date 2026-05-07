@extends('layouts.layout-master')

@section('title', 'Quản lý Câu trả lời')
@section('page_title', 'Quản lý Câu trả lời')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách câu trả lời</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.answer.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm câu trả lời
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped" id="answers-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Câu trả lời</th>
                            <th>Câu hỏi</th>
                            <th width="180">User</th>
                            <th width="170">Ngày tạo</th>
                            <th width="160">Hành động</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#answers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.content.answer.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'answer_text', name: 'content' },
            { data: 'question_text', name: 'question.question', orderable: false, searchable: false },
            { data: 'user_text', name: 'user.name', orderable: false, searchable: false },
            { data: 'created_date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
