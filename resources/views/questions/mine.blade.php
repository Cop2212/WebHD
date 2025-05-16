@extends('layouts.app')

@section('title', 'Câu hỏi của tôi')

@section('content')
<div class="container py-4">
    <h3 class="mb-4"><i class="fas fa-question-circle me-2"></i>Câu hỏi của tôi</h3>

    @forelse($questions as $question)
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <a href="{{ route('questions.show', $question) }}" class="h5 text-decoration-none">{{ $question->title }}</a>
                    <div class="text-muted small">
                        {{ $question->created_at->diffForHumans() }} • {{ $question->answers_count }} câu trả lời • {{ $question->votes_count }} lượt vote
                    </div>
                </div>
                <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Chỉnh sửa
                </a>
            </div>
        </div>
    @empty
        <p>Bạn chưa tạo câu hỏi nào.</p>
    @endforelse


    {{ $questions->links() }}
</div>
@endsection
