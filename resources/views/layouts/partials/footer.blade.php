<footer class="bg-dark text-white py-4 {{ $class ?? '' }}">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Giới thiệu -->
            <div class="col-md-6 mb-4">
                <h5 class="text-primary">{{ $title ?? 'LaraQ&A' }}</h5>
                <p class="small">{{ $description ?? 'Nền tảng hỏi đáp kiến thức cộng đồng.' }}</p>
            </div>

            <!-- Liên kết nhanh -->
            <div class="col-md-3 mb-4">
                <h5 class="text-primary">Liên kết</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ $links['questions'] ?? '#' }}" class="text-white text-decoration-none">Câu hỏi</a></li>
                    <li class="mb-2"><a href="{{ $links['tags'] ?? '#' }}" class="text-white text-decoration-none">Thẻ</a></li>
                    <li><a href="{{ $links['faq'] ?? '#' }}" class="text-white text-decoration-none">FAQ</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội -->
            <div class="col-md-3">
                <h5 class="text-primary">Kết nối</h5>
                <div class="social-links mb-3">
                    @foreach(($socials ?? []) as $social)
                        <a href="{{ $social['url'] }}" class="text-white me-2" target="_blank">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
                @if(isset($contact))
                    <div class="small">
                        <a href="{{ $contact }}" class="text-white text-decoration-none">Liên hệ</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center small pt-3 border-top border-secondary">
            <p class="mb-0">&copy; {{ date('Y') }} {{ $copyright ?? 'LaraQ&A' }}. All rights reserved.</p>
        </div>
    </div>
</footer>
