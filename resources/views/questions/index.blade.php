@extends('layouts.app')

@section('title', $selectedTags->isNotEmpty() ? 'Câu hỏi với tags: '.$selectedTags->pluck('name')->join(', ') : 'Danh sách câu hỏi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">
                    @if($selectedTags->isNotEmpty())
                        Câu hỏi với tags:
                        @foreach($selectedTags as $tag)
                            <span class="badge bg-primary me-1">{{ $tag->name }}</span>
                        @endforeach
                    @else
                        Tất cả câu hỏi
                    @endif
                </h1>

                <a href="{{ route('questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Đặt câu hỏi
                </a>
            </div>

            <!-- Form lọc theo tag -->
            <div class="mb-4">
                <div class="input-group">
                    <select name="tags[]" id="tag-select" class="form-select" multiple>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ $selectedTags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }} ({{ $tag->questions_count }})
                            </option>
                        @endforeach
                    </select>
                    <button type="button" id="filter-btn" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                    @if($selectedTags->isNotEmpty())
                        <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Xóa lọc
                        </a>
                    @endif
                </div>
                <div id="selected-tags-display" class="mt-2 d-flex flex-wrap gap-2">
                    @foreach($selectedTags as $tag)
                        <span class="badge bg-primary">
                            {{ $tag->name }}
                            <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                        </span>
                    @endforeach
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
    .tags-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .tag-item {
        display: inline-block;
        padding: 4px 12px;
        background: #e9ecef;
        border-radius: 20px;
        font-size: 14px;
        color: #495057;
        text-decoration: none;
        cursor: pointer;
    }
    .tag-item:hover {
        background: #dee2e6;
    }
    .tag-item.active {
        background: #0d6efd;
        color: white;
    }
    .tag-count {
        font-size: 12px;
        color: #6c757d;
        margin-left: 4px;
    }
    .tag-item.active .tag-count {
        color: #e9ecef;
    }
    #selected-tags-display .badge {
        font-size: 14px;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$(document).ready(function() {
    // Khởi tạo Select2
    $('#tag-select').select2({
        placeholder: "Chọn các tag...",
        allowClear: true,
        width: '100%'
    });

    // Mảng lưu các tag đã chọn
    let selectedTags = @json($selectedTags->map(function($tag) {
        return ['id' => $tag->id, 'name' => $tag->name];
    }));

    // Cập nhật hiển thị tags đã chọn
    function updateSelectedTagsDisplay() {
        $('#selected-tags-display').empty();
        selectedTags.forEach(tag => {
            $('#selected-tags-display').append(`
                <span class="badge bg-primary">
                    ${tag.name}
                    <input type="hidden" name="tags[]" value="${tag.id}">
                </span>
            `);
        });
    }

    // Hàm lọc câu hỏi bằng AJAX
    function filterQuestions() {
        const tagIds = selectedTags.map(tag => tag.id);

        $.ajax({
            url: "{{ route('questions.index') }}",
            type: "GET",
            data: { tags: tagIds },
            beforeSend: function() {
                $('#questions-container').addClass('loading');
            },
            success: function(response) {
                $('#questions-container').html(response.html);

                // Cập nhật tiêu đề
                if (selectedTags.length > 0) {
                    const tagNames = selectedTags.map(tag => tag.name).join(', ');
                    $('h1').html('Câu hỏi với tags: ' + tagNames);
                } else {
                    $('h1').html('Tất cả câu hỏi');
                }

                // Cập nhật URL không reload trang
                const url = new URL(window.location);
                if (tagIds.length > 0) {
                    url.searchParams.set('tags', tagIds);
                } else {
                    url.searchParams.delete('tags');
                }
                window.history.pushState({}, '', url);
            },
            complete: function() {
                $('#questions-container').removeClass('loading');
            }
        });
    }

    // Sự kiện khi chọn tag từ dropdown
    $('#tag-select').on('change', function() {
        const selectedOptions = $(this).select2('data');
        selectedTags = selectedOptions.map(option => {
            return {
                id: option.id,
                name: option.text.split(' (')[0] // Loại bỏ phần count trong tên
            };
        });
        updateSelectedTagsDisplay();
    });

    // Sự kiện khi click nút lọc
    $('#filter-btn').click(function() {
        filterQuestions();
    });

    // Sự kiện khi click tag phổ biến
    $('.tags-cloud .tag-item').click(function() {
        const tagId = $(this).data('tag-id');
        const tagName = $(this).text().split(' (')[0];

        // Kiểm tra nếu tag chưa được chọn
        if (!selectedTags.some(tag => tag.id == tagId)) {
            selectedTags.push({ id: tagId, name: tagName });

            // Cập nhật select2
            const currentValues = $('#tag-select').val() || [];
            $('#tag-select').val([...currentValues, tagId]).trigger('change');

            updateSelectedTagsDisplay();
            filterQuestions();
        }
    });

    // Khởi tạo hiển thị ban đầu
    updateSelectedTagsDisplay();
});
</script>
@endpush
