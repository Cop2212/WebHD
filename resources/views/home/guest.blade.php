@extends('layouts.app')

@section('title', 'Chào mừng đến Q&A')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-wrapper fade-in">
            <div class="auth-card">
                <div class="auth-hero">
                    <h1 class="auth-title">Chào mừng đến Q&A</h1>
                    <div class="auth-actions">
                        <a href="{{ route('register') }}" class="btn btn-register">
                            <i class="fas fa-user-plus me-2"></i> Đăng ký
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                        </a>
                    </div>
                </div>

                <div class="tags-cloud mb-4">
                    <h3 class="section-title mb-3">Chủ đề phổ biến</h3>
                    <div class="tags-container">
                        @foreach($popularTags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="tag-item">
                                {{ $tag->name }}
                                <span class="tag-count">{{ $tag->questions_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="popular-questions">
                    @if($popularQuestions->isNotEmpty())
                        <div class="question-grid">
                            @foreach($popularQuestions as $question)
                                @include('questions.question-card', ['question' => $question])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-question-circle"></i>
                            <p>Chưa có câu hỏi nổi bật</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
