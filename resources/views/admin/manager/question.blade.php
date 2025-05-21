@extends('layouts.admin')

@section('title', 'Danh sách câu hỏi')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-dark text-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-list-alt me-2"></i>Danh sách câu hỏi
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="80">ID</th>
                        <th>Tiêu đề</th>
                        <th width="200">Người đăng</th>
                        <th width="150">Ngày tạo</th>
                        <th width="120" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $question->id }}</td>
                            <td>
                                <a href="{{ route('questions.show', $question->id) }}" class="text-decoration-none text-dark hover-primary" data-bs-toggle="tooltip" title="{{ $question->title }}">
                                    {{ Str::limit($question->title, 50) }}
                                    @if($question->answers_count > 0)
                                        <span class="badge bg-success ms-2">{{ $question->answers_count }} trả lời</span>
                                    @endif
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <span class="avatar-title rounded-circle bg-light text-dark">
                                            {{ substr($question->user->name ?? 'K', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="d-block">{{ $question->user->name ?? 'Không rõ' }}</span>
                                        <small class="text-muted">{{ $question->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $question->created_at->format('d/m/Y') }}
                                </div>
                                <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <form action="{{ route('admin.questions.delete', $question->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Xóa">
                <i class="fas fa-trash-alt"></i> Xóa
            </button>
        </form>
    </div>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Không có câu hỏi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Hiển thị {{ $questions->firstItem() }} - {{ $questions->lastItem() }} của {{ $questions->total() }} kết quả
                    </div>
                    <div>
                        {{ $questions->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-primary:hover {
        color: #0d6efd !important;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: 600;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .card-footer {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
</script>
@endpush
