<div class="p-6 bg-white rounded-lg border border-gray-200 hover:shadow-md transition mb-4">
    <a href="{{ route('questions.show', $question->id) }}" class="text-xl font-semibold text-blue-600 hover:underline block">
        {{ $question->title }}
    </a>
    <p class="text-gray-700 mt-3">
        {{ Str::limit(strip_tags($question->content), 150) }}
    </p>
    <div class="mt-4 flex justify-between items-center text-sm">
        <div class="text-gray-500">
            <span>{{ $question->created_at->diffForHumans() }}</span>
            <span class="mx-2">•</span>
            <span>{{ $question->user->name }}</span>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($question->tags as $tag)
                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    </div>
</div>
