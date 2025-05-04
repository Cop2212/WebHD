<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-history text-gray-500 mr-2"></i> Câu hỏi gần đây
    </h2>

    <div class="space-y-4">
        @isset($recentQuestions)
            @foreach($recentQuestions as $question)
            <div class="border-b border-gray-100 pb-4">
                <a href="{{ route('questions.show', $question->id) }}" class="block hover:bg-gray-50 p-2 rounded">
                    <h3 class="font-medium text-blue-600">{{ $question->title }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mt-1">
                        <span>{{ $question->answers_count }} trả lời</span>
                        <span class="mx-2">•</span>
                        <span>Hỏi {{ $question->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        @endisset
    </div>

    <div class="mt-4">
        <a href="{{ route('questions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            Xem tất cả câu hỏi <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
