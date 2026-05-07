@extends('layouts.layout-master')

@section('title', 'Sửa Câu hỏi')
@section('page_title', 'Sửa Câu hỏi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật câu hỏi #{{ $question->id }}</h3>
            </div>
            <form action="{{ route('admin.content.question.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="question">Câu hỏi</label>
                        <textarea id="question" name="question" class="form-control @error('question') is-invalid @enderror" rows="4" required>{{ old('question', $question->question) }}</textarea>
                        @error('question')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Loại</label>
                        <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                            @foreach($types as $type)
                                <option value="{{ $type }}" @selected(old('type', $question->type) === $type)>{{ strtoupper($type) }}</option>
                            @endforeach
                        </select>
                        @error('type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.content.question.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
