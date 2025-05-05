@if($questions->isNotEmpty())
    <div class="question-list">
        @foreach($questions as $question)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-center me-3" style="width: 60px;">
                            <div class="mb-2">
                                <span class="badge bg-light text-dark">{{ $question->answers_count }}</span>
                                <div class="small">câu trả lời</div>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark">{{ $question->votes_count }}</span>
                                <div class="small">lượt vote</div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title">
                                <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                            </h5>
                            <div class="mb-2">
                                @foreach($question->tags as $tag)
                                    <a href="{{ route('questions.index', ['tags[]' => $tag->id]) }}"
                                       class="badge bg-secondary text-decoration-none me-1">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Đăng bởi
                                    <a href="#">{{ $question->user->name }}</a>
                                    {{ $question->created_at->diffForHumans() }}
                                </div>
                                <div class="text-muted small">
                                    {{ $question->views }} lượt xem
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $questions->withQueryString()->links() }}
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
