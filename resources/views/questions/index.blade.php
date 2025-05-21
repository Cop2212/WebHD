@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách câu hỏi</h1>

        {{-- Hiển thị danh sách câu hỏi ở đây --}}
        @foreach ($questions as $question)
            <div class="mb-3">
                <h3>{{ $question->title }}</h3>
                <p>{{ $question->body }}</p>
            </div>
        @endforeach
    </div>
@endsection
