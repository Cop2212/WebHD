@extends('layouts.app')

@section('title', 'Chào mừng đến Q&A')

@section('content')
<div class="guest-page py-5">
    <div class="container-fluid px-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- Welcome Card -->
                <div class="welcome-card shadow-sm rounded-4 p-4 p-md-5 mb-5 fade-in">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h1 class="welcome-title display-5 fw-bold mb-4">
                                Chào mừng đến Q&A
                                <span class="text-primary">Tri thức cộng đồng</span>
                            </h1>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-user-plus me-2"></i> Đăng ký
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">
                                    <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('images/welcome-illustration.svg') }}"
                                 alt="Welcome Illustration"
                                 class="img-fluid d-none d-md-block">
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row g-4">
                    <!-- Popular Questions -->
                    <div class="col-lg-8">
                        <div class="popular-questions card border-0 shadow-sm rounded-4 p-4 h-100">
                            <h2 class="section-title mb-4">
                                <i class="fas fa-fire text-danger me-2"></i>
                                Câu hỏi nổi bật
                            </h2>
                            @if($popularQuestions->isNotEmpty())
                                @include('questions._question_list', ['questions' => $popularQuestions])
                            @else
                                <div class="empty-state text-center py-5">
                                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted fs-5">Chưa có câu hỏi nổi bật</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="col-lg-4">
                        <div class="tags-cloud card border-0 shadow-sm rounded-4 p-4 h-100">
                            <h2 class="section-title mb-4">
                                <i class="fas fa-tags text-success me-2"></i>
                                Chủ đề phổ biến
                            </h2>
                            <div class="tags-container d-flex flex-wrap gap-2">
                                @foreach($popularTags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}"
                                       class="tag-item btn btn-sm btn-outline-success position-relative">
                                        {{ $tag->name }}
                                        <span class="tag-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                            {{ $tag->questions_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
