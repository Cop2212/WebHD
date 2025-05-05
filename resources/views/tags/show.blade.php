@extends('layouts.app')

@section('title', $selectedTags->isNotEmpty()
    ? 'Câu hỏi với tags: '.$selectedTags->pluck('name')->join(', ')
    : ($tag ? 'Câu hỏi với tag: '.$tag->name : 'Danh sách câu hỏi'))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0">
                        @if($selectedTags->isNotEmpty())
                            Các tag:
                            @foreach($selectedTags as $selectedTag)
                                <span class="badge bg-primary me-1">{{ $selectedTag->name }}</span>
                            @endforeach
                        @elseif($tag)
                            Tag: {{ $tag->name }}
                        @else
                            Tất cả câu hỏi
                        @endif
                    </h1>
                    <span class="badge bg-primary ms-3">
                        {{ $questions->total() }} câu hỏi
                    </span>
                </div>

                @auth
                    <a href="{{ route('questions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Đặt câu hỏi
                    </a>
                @endauth
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Lọc câu hỏi với {{ $tag->name }} và:</h5>

                    <!-- Select2 Dropdown -->
                    <div class="mb-3">
                        <select name="tags[]" id="tag-select" class="form-select" multiple>
                            @foreach($allTags as $t)
                                @if($t->id != $tag->id)
                                    <option value="{{ $t->id }}"
                                        {{ in_array($t->id, $selectedTags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $t->name }} ({{ $t->questions_count }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Button Tags -->
                    <div class="tags-filter-container mb-3">
                        @foreach($allTags as $t)
                            @if($t->id != $tag->id)
                                <button type="button"
                                        class="btn btn-sm tag-filter-btn {{ in_array($t->id, $selectedTags->pluck('id')->toArray()) ? 'btn-primary' : 'btn-outline-primary' }}"
                                        data-tag-id="{{ $t->id }}">
                                    {{ $t->name }} ({{ $t->questions_count }})
                                </button>
                            @endif
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('tags.show', $tag->slug) }}" id="tag-filter-form">
                        <input type="hidden" name="tags" id="selected-tags-input"
                               value="{{ implode(',', array_diff($selectedTags->pluck('id')->toArray(), [$tag->id])) }}">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Áp dụng lọc
                            </button>
                            @if($selectedTags->count() > 1)
                                <a href="{{ route('tags.show', $tag->slug) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Xóa lọc
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div id="questions-container">
                @include('questions._questions_list', ['questions' => $questions])
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
        color: white;
        border: none;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    const currentTagId = {{ $tag->id }};

    // Khởi tạo Select2
    $('#tag-select').select2({
        placeholder: "Chọn thêm tag...",
        allowClear: true,
        width: '100%'
    });

    // Xử lý click button tag
    $('.tag-filter-btn').click(function() {
        $(this).toggleClass('btn-primary btn-outline-primary');
        updateSelectedTags();
    });

    // Cập nhật danh sách tag đã chọn
    function updateSelectedTags() {
        let selectedTags = [currentTagId]; // Luôn bao gồm tag hiện tại

        // Lấy các tag được chọn thêm
        $('.tag-filter-btn.btn-primary').each(function() {
            selectedTags.push($(this).data('tag-id'));
        });

        // Cập nhật input ẩn (loại bỏ giá trị trùng)
        const uniqueTags = [...new Set(selectedTags)];
        $('#selected-tags-input').val(uniqueTags.join(','));
    }

    // Tự động submit form khi có thay đổi
    $('.tag-filter-btn').click(function() {
        $('#tag-filter-form').submit();
    });

    // Khởi tạo trạng thái ban đầu
    @foreach($selectedTags as $selectedTag)
        @if($selectedTag->id != $tag->id)
            $('[data-tag-id="{{ $selectedTag->id }}"]')
                .addClass('btn-primary')
                .removeClass('btn-outline-primary');
        @endif
    @endforeach
});
</script>
@endpush
