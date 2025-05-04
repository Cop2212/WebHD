<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-fire text-red-500 mr-2"></i> Câu hỏi nổi bật
    </h2>

    <div class="space-y-4">
        @isset($popularQuestions)
            @foreach($popularQuestions as $question)
            <div class="border-b border-gray-100 pb-4">
                <a href="{{ route('questions.show', $question->id) }}" class="block hover:bg-gray-50 p-2 rounded">
                    <h3 class="font-medium text-blue-600">{{ $question->title }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mt-1">
                        <span>{{ $question->answers_count }} trả lời</span>
                        <span class="mx-2">•</span>
                        <span>{{ $question->views }} lượt xem</span>
                    </div>
                </a>
            </div>
            @endforeach
        @endisset
    </div>

    <div class="mt-4">
        @auth
            <a href="{{ route('questions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Xem thêm <i class="fas fa-arrow-right ml-1"></i>
            </a>
        @else
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Đăng ký để xem thêm <i class="fas fa-arrow-right ml-1"></i>
            </a>
        @endauth
    </div>
</div>
