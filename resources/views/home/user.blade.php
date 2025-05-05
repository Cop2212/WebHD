@extends('layouts.app')

@section('title', 'Trang chủ Q&A')

@section('content')
<div class="dashboard-page">
    <div class="container">

        <div class="dashboard-header">
            <div class="user-greeting">
                <h1>Xin chào, {{ Auth::user()->name }}</h1>
                <p class="welcome-message">Chúc bạn một ngày tốt lành!</p>
            </div>
        </div>

        <div class="dashboard-actions">
            <h2 class="section-title">Câu hỏi mới nhất</h2>
            <a href="{{ route('questions.create') }}" class="btn btn-new-question">
                <i class="fas fa-plus me-1"></i> Đặt câu hỏi
            </a>
        </div>

        <!-- Danh sách câu hỏi -->
        @if($questions->isNotEmpty())
            <div class="question-list mt-4">
                @foreach($questions as $question)
                    @include('questions.question-card', ['question' => $question])
                @endforeach

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $questions->links() }}
                </div>
            </div>
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
