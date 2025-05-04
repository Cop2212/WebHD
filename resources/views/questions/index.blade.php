@extends('layouts.app')

@section('title', 'Questions')

@section('content')
    <div class="questions-header">
        <h1>All Questions</h1>
        <a href="{{ route('questions.create') }}" class="btn">Ask Question</a>
    </div>

    <div class="questions-list">
        @foreach($questions as $question)
            <div class="question-card">
                <h3><a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a></h3>
                <p>{{ Str::limit($question->body, 200) }}</p>
                <div class="question-meta">
                    <span>{{ $question->answers_count }} answers</span>
                    <span>Asked by {{ $question->user->name }}</span>
                </div>
            </div>
        @endforeach
    </div>

    {{ $questions->links() }}
@endsection
