@extends('layouts.layout-master')

@section('title', 'Sửa Từ vựng')
@section('page_title', 'Sửa Từ vựng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật từ vựng #{{ $vocabulary->id }}</h3>
            </div>
            <form action="{{ route('admin.content.vocabulary.update', $vocabulary) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="english_word">Từ tiếng Anh</label>
                        <input id="english_word" type="text" name="english_word" class="form-control @error('english_word') is-invalid @enderror" value="{{ old('english_word', $vocabulary->english_word) }}" required>
                        @error('english_word')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="vietnamese_word">Nghĩa tiếng Việt</label>
                        <textarea id="vietnamese_word" name="vietnamese_word" class="form-control @error('vietnamese_word') is-invalid @enderror" rows="4">{{ old('vietnamese_word', $vocabulary->vietnamese_word) }}</textarea>
                        @error('vietnamese_word')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.content.vocabulary.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
