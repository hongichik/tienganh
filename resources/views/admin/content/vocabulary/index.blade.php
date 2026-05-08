@extends('layouts.layout-master')

@section('title', 'Quản lý Từ vựng')
@section('page_title', 'Quản lý Từ vựng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách từ vựng</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.vocabulary.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm từ vựng
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped" id="vocabularies-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Tiếng Anh</th>
                            <th>Tiếng Việt</th>
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
    $('#vocabularies-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.content.vocabulary.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'english_text', name: 'english_word' },
            { data: 'vietnamese_text', name: 'vietnamese_word' },
            { data: 'created_date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
