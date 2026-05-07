@extends('layouts.layout-master')

@section('title', 'Thêm Câu trả lời')
@section('page_title', 'Thêm Câu trả lời')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tạo câu trả lời mới</h3>
            </div>
            <form action="{{ route('admin.content.answer.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="question_id">Câu hỏi</label>
                        <select id="question_id" name="question_id" class="form-control @error('question_id') is-invalid @enderror" required>
                            <option value="">-- Chọn câu hỏi --</option>
                            @foreach($questions as $question)
                                <option value="{{ $question->id }}" @selected(old('question_id') == $question->id)>
                                    [{{ strtoupper($question->type) }}] {{ \Illuminate\Support\Str::limit($question->question, 90) }}
                                </option>
                            @endforeach
                        </select>
                        @error('question_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="user_id">Người dùng</label>
                        <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">-- Không gán user --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung trả lời</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content') }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('admin.content.answer.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
