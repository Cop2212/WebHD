@extends('layouts.app')

@section('title', 'Tag: ' . $tag->name)

@section('content')
<div class="tag-page py-5">
    <div class="container">
        <!-- Tag Header Component -->
        <div class="tag-header card shadow-sm mb-5">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-3" style="font-size: 1.5rem; padding: 0.5rem 1rem;">
                                {{ $tag->name }}
                            </span>
                            <div>
                                <h1 class="mb-2">{{ $tag->name }}</h1>
                                @if($tag->description)
                                <p class="text-muted mb-0">
                                    {{ $tag->description }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="tag-stats row g-4 mb-5">
            <div class="col-md-6">
                <div class="stat-card card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-question text-primary"></i>
                        </div>
                        <h3 class="stat-number mt-3">{{ $questions->total() }}</h3>
                        <p class="stat-label text-muted">Câu hỏi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-users text-success"></i>
                        </div>
                        <h3 class="stat-number mt-3">{{ $usersCount }}</h3>
                        <p class="stat-label text-muted">Người dùng</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="questions-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Câu hỏi với tag "{{ $tag->name }}"</h2>
                <a href="{{ route('questions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Đặt câu hỏi
                </a>
            </div>

            @include('questions._question_list', ['questions' => $questions])
        </div>

        <!-- Related Tags Section -->
        @if($relatedTags->isNotEmpty())
        <div class="related-tags mt-5">
            <h3 class="mb-4">Tags liên quan</h3>
            <div class="tags-container">
                @foreach($relatedTags as $relatedTag)
                    <a href="{{ route('tags.show', $relatedTag->slug) }}"
                       class="btn btn-outline-primary btn-sm me-2 mb-2">
                        {{ $relatedTag->name }} ({{ $relatedTag->questions_count }})
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .tag-page {
        background-color: #f8f9fa;
    }

    .tag-header {
        background-color: #fff;
        border-radius: 0.5rem;
    }

    .stat-card {
        border-radius: 0.5rem;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .stat-number {
        font-weight: 700;
        color: #333;
    }

    .stat-label {
        font-size: 0.9rem;
    }

    .empty-state {
        background-color: #fff;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
</style>
@endpush
