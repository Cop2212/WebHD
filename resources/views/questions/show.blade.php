@extends('layouts.app')

@section('content')
<div class="container">
    <div class="question-detail mb-4">
        <h2>{{ $question->title }}</h2>
        <div class="text-muted mb-2">
            Hỏi bởi <strong>{{ $question->user->name }}</strong> • {{ $question->created_at->diffForHumans() }}
        </div>

        <div class="mb-3" style="word-break: break-word;">
    {!! nl2br(e($question->body)) !!}
</div>


        <div class="mb-3">
            @foreach ($question->tags as $tag)
                <a href="{{ route('tags.show', $tag) }}" class="badge bg-primary text-decoration-none">{{ $tag->name }}</a>
            @endforeach
        </div>

        <div class="d-flex align-items-center mt-4">
            <span class="me-3">👍 {{ $question->votes_count }} votes</span>
            <span class="me-3">💬 {{ $question->answers_count }} câu trả lời</span>
            <span>👁️ {{ $question->views_count }} lượt xem</span>
        </div>
    </div>

    <hr>

    <div class="answers mt-4">
        <h4>Câu trả lời</h4>

        @forelse ($question->answers as $answer)
            <div class="card mb-3">
                <div class="card-body">
                    {!! nl2br(e($answer->body)) !!}
                    <div class="text-muted small mt-2">
                        Trả lời bởi <strong>{{ $answer->user->name }}</strong> • {{ $answer->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có câu trả lời nào.</p>
        @endforelse
    </div>
</div>
@endsection
