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

            <div class="user-actions">
                <div class="dropdown user-dropdown">
                    <button class="btn btn-account dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> Tài khoản
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="dashboard-actions">
            <h2 class="section-title">Câu hỏi mới nhất</h2>
            <a href="{{ route('questions.create') }}" class="btn btn-new-question">
                <i class="fas fa-plus me-1"></i> Đặt câu hỏi
            </a>
        </div>

        @if($questions->isNotEmpty())
            <div class="question-list">
                @foreach($questions as $question)
                    @include('partials.question-card', ['question' => $question])
                @endforeach
                {{ $questions->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <p>Chưa có câu hỏi nào</p>
                <a href="{{ route('questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tạo câu hỏi đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
