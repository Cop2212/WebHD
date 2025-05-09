@if($questions->isNotEmpty())
    <div class="question-list">
        @foreach($questions as $question)
            @include('questions._question_card', ['question' => $question])
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{-- Kiểm tra nếu là Paginator thì dùng withQueryString --}}
            @if(method_exists($questions, 'withQueryString'))
                {{ $questions->withQueryString()->links() }}
            @else
                {{-- Nếu là Collection thì chỉ hiển thị links nếu có --}}
                @if(method_exists($questions, 'links'))
                    {{ $questions->links() }}
                @endif
            @endif
        </div>
    </div>
@else
    <div class="empty-state text-center py-5">
        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
        <h4 class="mb-3">Không tìm thấy câu hỏi nào</h4>
        <a href="{{ route('questions.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Xem tất cả câu hỏi
        </a>
    </div>
@endif
