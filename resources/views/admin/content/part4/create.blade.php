@extends('layouts.layout-master')

@section('title', 'Thêm đề Part 4')
@section('page_title', 'Thêm đề viết Part 4')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tạo đề mới</h3>
            </div>
            <form action="{{ route('admin.content.part4.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Tiêu đề đề</label>
                        <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="introduction">Nội dung email từ manager</label>
                        <textarea id="introduction" name="introduction" rows="5" class="form-control @error('introduction') is-invalid @enderror" required>{{ old('introduction') }}</textarea>
                        @error('introduction')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="manager_email">Chữ ký manager</label>
                        <input id="manager_email" name="manager_email" type="text" class="form-control @error('manager_email') is-invalid @enderror" value="{{ old('manager_email', 'Best, Club Manager.') }}" required>
                        @error('manager_email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="task_one_instruction">Yêu cầu phần 1</label>
                        <textarea id="task_one_instruction" name="task_one_instruction" rows="3" class="form-control @error('task_one_instruction') is-invalid @enderror" required>{{ old('task_one_instruction') }}</textarea>
                        @error('task_one_instruction')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="task_two_instruction">Yêu cầu phần 2</label>
                        <textarea id="task_two_instruction" name="task_two_instruction" rows="3" class="form-control @error('task_two_instruction') is-invalid @enderror" required>{{ old('task_two_instruction') }}</textarea>
                        @error('task_two_instruction')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <hr>
                    <h5>Đáp án tham khảo (tùy chọn)</h5>

                    <div class="form-group">
                        <label for="sample_answer_1">Mẫu trả lời phần 1</label>
                        <textarea id="sample_answer_1" name="sample_answer_1" rows="4" class="form-control @error('sample_answer_1') is-invalid @enderror">{{ old('sample_answer_1') }}</textarea>
                        @error('sample_answer_1')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group mb-0">
                        <label for="sample_answer_2">Mẫu trả lời phần 2</label>
                        <textarea id="sample_answer_2" name="sample_answer_2" rows="6" class="form-control @error('sample_answer_2') is-invalid @enderror">{{ old('sample_answer_2') }}</textarea>
                        @error('sample_answer_2')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu đề</button>
                    <a href="{{ route('admin.content.part4.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
