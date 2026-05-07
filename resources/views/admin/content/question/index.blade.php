@extends('layouts.layout-master')

@section('title', 'Quản lý Câu hỏi')
@section('page_title', 'Quản lý Câu hỏi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách câu hỏi</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.question.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm câu hỏi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped" id="questions-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Câu hỏi</th>
                            <th width="120">Loại</th>
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
    $('#questions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.content.question.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'question_text', name: 'question' },
            { data: 'type_badge', name: 'type', orderable: false, searchable: true },
            { data: 'created_date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
