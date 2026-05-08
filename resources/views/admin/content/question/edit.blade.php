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

                    <div id="viet3-fields" class="border rounded p-3" style="display:none; background:#f8f9fa;">
                        <div class="mb-2"><strong>Nội dung chat cho VIET3</strong></div>

                        <div class="form-group">
                            <label for="chat_prompt_1">Chat 1 (Kim)</label>
                            <textarea
                                id="chat_prompt_1"
                                name="chat_prompt_1"
                                class="form-control @error('chat_prompt_1') is-invalid @enderror"
                                rows="3"
                            >{{ old('chat_prompt_1', data_get($question->meta, 'chat_prompts.0')) }}</textarea>
                            @error('chat_prompt_1')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="chat_prompt_2">Chat 2 (Marco)</label>
                            <textarea
                                id="chat_prompt_2"
                                name="chat_prompt_2"
                                class="form-control @error('chat_prompt_2') is-invalid @enderror"
                                rows="3"
                            >{{ old('chat_prompt_2', data_get($question->meta, 'chat_prompts.1')) }}</textarea>
                            @error('chat_prompt_2')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="chat_prompt_3">Chat 3 (Sylvia)</label>
                            <textarea
                                id="chat_prompt_3"
                                name="chat_prompt_3"
                                class="form-control @error('chat_prompt_3') is-invalid @enderror"
                                rows="3"
                            >{{ old('chat_prompt_3', data_get($question->meta, 'chat_prompts.2')) }}</textarea>
                            @error('chat_prompt_3')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var typeEl = document.getElementById('type');
    var viet3Fields = document.getElementById('viet3-fields');
    var chatIds = ['chat_prompt_1', 'chat_prompt_2', 'chat_prompt_3'];

    function syncViet3Fields() {
        var isViet3 = typeEl && typeEl.value === 'viet3';
        viet3Fields.style.display = isViet3 ? 'block' : 'none';

        chatIds.forEach(function (id) {
            var field = document.getElementById(id);
            if (!field) {
                return;
            }

            if (isViet3) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }

    if (typeEl) {
        typeEl.addEventListener('change', syncViet3Fields);
    }

    syncViet3Fields();
});
</script>
@endsection
