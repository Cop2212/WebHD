@foreach ($questions as $question)
    <!-- Hiển thị mỗi câu hỏi -->
    <div class="mb-4 p-4 bg-white dark:bg-gray-700 rounded shadow">
        <a href="{{ route('questions.show', $question->id) }}" class="text-lg font-bold text-blue-600">
            {{ $question->title }}
        </a>
        <div class="text-sm text-gray-500 mt-1">
            Asked by {{ $question->user->name }} • {{ $question->created_at->diffForHumans() }}
        </div>
        <div class="mt-2 flex gap-2 flex-wrap">
            @foreach($question->tags as $tag)
                <span class="text-xs px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded-full">#{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
@endforeach
