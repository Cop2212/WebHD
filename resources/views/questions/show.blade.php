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
            <form action="{{ route('questions.vote', $question) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-sm {{ $question->isVotedByUser(auth()->id()) ? 'btn-success' : 'btn-outline-success' }}">
        👍 {{ $question->votes_count }}
    </button>
</form>


            <span class="me-3">💬 {{ $question->comments_count }} bình luận</span>
            <span>👁️ {{ $question->view_count }} lượt xem</span>
        </div>
    </div>

    <hr>
    {{-- Hiển thị comment --}}
<div class="mt-4">
        <h5>Bình luận</h5>

        @forelse ($question->comments as $comment)
            <div class="border-bottom pb-2 mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <div class="text-muted small">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>

                    {{-- Vote buttons --}}
                    <div>
                        <form action="{{ route('comments.vote', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="value" value="1">
                            <button class="btn btn-sm {{ $comment->votes->where('user_id', auth()->id())->first()?->value === 1 ? 'btn-success' : 'btn-outline-success' }}">▲</button>
                        </form>

                        <span class="mx-1">{{ $comment->votes->sum('value') }}</span>

                        <form action="{{ route('comments.vote', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="value" value="-1">
                            <button class="btn btn-sm {{ $comment->votes->where('user_id', auth()->id())->first()?->value === -1 ? 'btn-danger' : 'btn-outline-danger' }}">▼</button>
                        </form>
                    </div>
                </div>

                <p class="mt-2 mb-0">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-muted">Chưa có bình luận nào.</p>
        @endforelse

        {{-- Form gửi bình luận --}}
        @auth
            <form action="{{ route('questions.comments.store', $question) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="body" class="form-control mb-2" rows="3" placeholder="Nhập bình luận..."></textarea>
                <button class="btn btn-primary btn-sm">Gửi bình luận</button>
            </form>
        @endauth
    </div>
</div>
@endsection
