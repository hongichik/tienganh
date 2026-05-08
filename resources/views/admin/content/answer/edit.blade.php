@extends('layouts.layout-master')

@section('title', 'Sửa Câu trả lời')
@section('page_title', 'Sửa Câu trả lời')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật câu trả lời #{{ $answer->id }}</h3>
            </div>
            <form action="{{ route('admin.content.answer.update', $answer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="question_id">Câu hỏi</label>
                        <select id="question_id" name="question_id" class="form-control @error('question_id') is-invalid @enderror" required>
                            @foreach($questions as $question)
                                <option value="{{ $question->id }}" data-type="{{ $question->type }}" @selected(old('question_id', $answer->question_id) == $question->id)>
                                    [{{ strtoupper($question->type) }}] {{ \Illuminate\Support\Str::limit($question->question, 90) }}
                                </option>
                            @endforeach
                        </select>
                        @error('question_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div id="answer-position-wrap" class="form-group" style="display:none;">
                        <label for="answer_position">Vị trí đáp án (chỉ dùng cho VIET3)</label>
                        <select id="answer_position" name="answer_position" class="form-control @error('answer_position') is-invalid @enderror">
                            <option value="">-- Chọn vị trí --</option>
                            <option value="1" @selected(old('answer_position', $answer->answer_position) == 1)>Ô trả lời 1 (Kim)</option>
                            <option value="2" @selected(old('answer_position', $answer->answer_position) == 2)>Ô trả lời 2 (Marco)</option>
                            <option value="3" @selected(old('answer_position', $answer->answer_position) == 3)>Ô trả lời 3 (Sylvia)</option>
                        </select>
                        @error('answer_position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="user_id">Người dùng</label>
                        <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">-- Không gán user --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id', $answer->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung trả lời</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $answer->content) }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.content.answer.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var questionSelect = document.getElementById('question_id');
    var positionWrap = document.getElementById('answer-position-wrap');
    var positionField = document.getElementById('answer_position');

    function syncPositionField() {
        var selected = questionSelect.options[questionSelect.selectedIndex];
        var type = selected ? selected.getAttribute('data-type') : null;
        var isViet3 = type === 'viet3';

        positionWrap.style.display = isViet3 ? 'block' : 'none';

        if (isViet3) {
            positionField.setAttribute('required', 'required');
        } else {
            positionField.removeAttribute('required');
            positionField.value = '';
        }
    }

    questionSelect.addEventListener('change', syncPositionField);
    syncPositionField();
});
</script>
@endsection
