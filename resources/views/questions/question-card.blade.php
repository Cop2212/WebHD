<div class="card mb-3 question-card">
    <div class="card-body">
        <div class="d-flex">
            <!-- Phần vote -->
            <div class="vote-section pe-3 text-center">
                <div class="vote-count">{{ $question->votes_count ?? 0 }}</div>
                <small>votes</small>
            </div>

            <!-- Nội dung -->
            <div class="flex-grow-1">
                <h5 class="card-title">
                    <a href="{{ route('tags.show', $question->id) }}">{{ $question->title }}</a>
                </h5>

                <p class="card-text text-muted">{{ Str::limit($question->body, 200) }}</p>

                <!-- Tags -->
                <div class="tags mb-2">
                    @foreach($question->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <!-- Thông tin người đăng -->
                <div class="d-flex justify-content-between">
                    <div class="user-info">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $question->user->name }}
                            | <i class="fas fa-clock"></i> {{ $question->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="answers-count">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-comment"></i> {{ $question->answers_count }} trả lời
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
