@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- DEBUG: Hiển thị số tags -->
    <div class="bg-blue-100 p-3 mb-4 rounded">
        <p class="font-bold">DEBUG: Có {{ $tags->count() }} tags được tải</p>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Đặt câu hỏi mới</h1>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            <!-- Phần tags - SỬA LẠI THEO CÁCH NÀY -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <label class="block font-medium text-gray-700 mb-2">Tags</label>
                <div class="space-y-2">
                    @foreach($tags as $tag)
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="tag_{{ $tag->id }}"
                               name="tags[]"
                               value="{{ $tag->id }}"
                               class="h-4 w-4 text-blue-600 rounded border-gray-300">
                        <label for="tag_{{ $tag->id }}" class="ml-2 text-gray-700">
                            {{ $tag->name }} <span class="text-xs text-gray-500">(ID: {{ $tag->id }})</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Các trường khác -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Đăng câu hỏi
            </button>
        </form>
    </div>
</div>
@endsection
