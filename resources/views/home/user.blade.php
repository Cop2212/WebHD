@extends('layouts.app')

@section('title', 'Trang chủ Q&A')

@section('content')
<div class="dashboard-page">
    <div class="container">
        <!-- Tag Filter Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Lọc câu hỏi theo tag</h5>

                <!-- Select2 Dropdown -->
                <div class="mb-3">
                    <select name="tags[]" id="tag-select" class="form-select" multiple>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ $selectedTags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }} ({{ $tag->questions_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Button Tags -->
                <div class="tags-filter-container mb-3">
                    @foreach($allTags as $tag)
                        <button type="button"
                                class="btn btn-sm tag-filter-btn {{ $selectedTags->contains($tag->id) ? 'btn-primary' : 'btn-outline-primary' }}"
                                data-tag-id="{{ $tag->id }}">
                            {{ $tag->name }} ({{ $tag->questions_count }})
                        </button>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('home') }}" id="tag-filter-form">
                    <input type="hidden" name="tags" id="selected-tags-input"
                           value="{{ $selectedTags->pluck('id')->implode(',') }}">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Áp dụng lọc
                        </button>
                        @if($selectedTags->isNotEmpty())
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Xóa lọc
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-end">
    <a href="{{ route('questions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Đặt câu hỏi
    </a>
</div>

        <!-- Questions Section -->
        @if($questions->isNotEmpty())
            @include('questions._question_list', ['questions' => $questions])
        @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                <h4 class="mb-3">Chưa có câu hỏi nào</h4>
                <p class="text-muted mb-4">Hãy là người đầu tiên đặt câu hỏi!</p>
                <a href="{{ route('questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tạo câu hỏi đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .tags-filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag-filter-btn {
        transition: all 0.2s ease;
        padding: 0.25rem 0.75rem;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        min-height: 38px;
        border-radius: 0.375rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 2px;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#tag-select').select2({
        placeholder: "Chọn các tag...",
        allowClear: true,
        width: '100%'
    });

    // Handle tag button click
    $('.tag-filter-btn').click(function() {
        $(this).toggleClass('btn-primary btn-outline-primary');
        updateSelectedTags();
    });

    // Update selected tags
    function updateSelectedTags() {
        let selectedTags = [];
        $('.tag-filter-btn.btn-primary').each(function() {
            selectedTags.push($(this).data('tag-id'));
        });
        $('#selected-tags-input').val(selectedTags.join(','));
    }

    // Auto submit when tags change
    $('.tag-filter-btn').click(function() {
        $('#tag-filter-form').submit();
    });

    // Initialize selected tags
    @foreach($selectedTags as $tag)
        $('[data-tag-id="{{ $tag->id }}"]')
            .addClass('btn-primary')
            .removeClass('btn-outline-primary');
    @endforeach
});
</script>
@endpush
