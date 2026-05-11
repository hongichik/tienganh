@extends('layouts.layout-master')

@section('title', 'Sửa Tài khoản người dùng')
@section('page_title', 'Sửa Tài khoản người dùng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật tài khoản người dùng</h3>
            </div>
            <form action="{{ route('admin.content.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="is_pro">Loại tài khoản</label>
                        <select id="is_pro" name="is_pro" class="form-control @error('is_pro') is-invalid @enderror" required>
                            <option value="0" {{ (string) old('is_pro', (int) $user->is_pro) === '0' ? 'selected' : '' }}>Không Pro</option>
                            <option value="1" {{ (string) old('is_pro', (int) $user->is_pro) === '1' ? 'selected' : '' }}>Pro</option>
                        </select>
                        @error('is_pro')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.content.user.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
