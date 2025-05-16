<div class="card mb-3 question-card">
    <div class="card-body">
        <div class="d-flex">
            <!-- Phần vote - Sử dụng $question->votes_count -->
            <div class="vote-section pe-3 text-center">
                <div class="vote-count">{{ $question->vote_count ?? 0 }}</div>
                <small>votes</small>
            </div>

            <!-- Nội dung chính -->
            <div class="flex-grow-1">
                <!-- Sử dụng $question->title và $question->id (trong route) -->
                <h5 class="card-title">
                    <a href="{{ Auth::check() ? route('questions.show', $question) : route('login') }}">
    {{ $question->title }}
</a>

                </h5>

                <!-- Sử dụng $question->body -->
                <p class="card-text text-muted" style="word-break: break-word;">
    {{ Str::limit($question->body, 200) }}
</p>


                <!-- Tags - Sử dụng $question->tags và $tag->slug, $tag->name -->
                <div class="tags mb-2">
                    @foreach($question->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}"
                           class="badge bg-primary text-decoration-none me-1">
                           {{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Thông tin người đăng -->
                <div class="d-flex justify-content-between">
                    <small class="text-muted">
                        <!-- Sử dụng $question->user->name và $question->created_at -->
                        <i class="fas fa-user me-1"></i>{{ $question->user->name }}
                        <i class="fas fa-clock mx-2"></i>{{ $question->created_at->diffForHumans() }}
                    </small>
                    <!-- Sử dụng $question->answers_count -->
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-comment me-1"></i>{{ $question->answers_count }} trả lời
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
