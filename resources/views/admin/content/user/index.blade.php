@extends('layouts.layout-master')

@section('title', 'Quản lý Tài khoản người dùng')
@section('page_title', 'Quản lý Tài khoản người dùng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách tài khoản người dùng</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.user.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm tài khoản
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="users-table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="22%">Tên</th>
                                <th>Email</th>
                                <th width="12%">Loại</th>
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
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.content.user.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'pro_badge', name: 'is_pro' },
            { data: 'created_date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
