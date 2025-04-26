<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chào mừng đến với Hệ thống Hỏi Đáp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 p-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">HỆ THỐNG HỎI ĐÁP TRI THỨC</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">Nơi kết nối và chia sẻ kiến thức</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition">
                        Đăng ký ngay
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 border border-blue-600 text-blue-600 dark:text-blue-300 rounded-full font-semibold hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                        Đăng nhập
                    </a>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                        <div class="space-y-6">
                            @forelse($questions as $question)
                            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition">
                                <a href="{{ route('login', $question->id) }}" class="text-xl font-semibold text-blue-600 dark:text-blue-300 hover:underline">
                                    {{ $question->title }}
                                </a>
                                <p class="text-gray-700 dark:text-gray-300 mt-3">
                                    {{ Str::limit(strip_tags($question->content), 150) }}
                                </p>
                                <div class="mt-4 flex justify-between items-center">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="far fa-clock mr-1"></i> {{ $question->created_at->diffForHumans() }}
                                        <span class="mx-2">•</span>
                                        <i class="far fa-user mr-1"></i> {{ $question->user->name }}
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($question->tags->take(3) as $tag)
                                        <span class="px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full">
                                            {{ $tag->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-600 dark:text-gray-400 text-center py-8">Chưa có câu hỏi nào</p>
                            @endforelse
                        </div>

                        <!-- Thêm phần phân trang vào cuối danh sách câu hỏi -->
@if($questions instanceof \Illuminate\Pagination\AbstractPaginator)
<div class="mt-4">
    {{ $questions->links() }}
</div>
@endif


                    </div>
                </div>

                <!-- Sidebar -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Thống kê cộng đồng</h4>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                            <li class="flex justify-between">
                                <span>Thành viên</span>
                                <span class="font-semibold">{{ $userCount }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Câu hỏi</span>
                                <span class="font-semibold">{{ $questionCount }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Câu trả lời</span>
                                <span class="font-semibold">{{ $answerCount }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Tại sao tham gia?</h4>
                        <ul class="space-y-4 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Đặt câu hỏi và nhận câu trả lời từ cộng đồng</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Chia sẻ kiến thức và kinh nghiệm của bạn</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Kết nối với những người cùng sở thích</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-blue-600 dark:bg-blue-800 rounded-lg p-8 mt-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-4">BẠN ĐÃ SẴN SÀNG THAM GIA?</h3>
                <p class="text-blue-100 mb-6">Đăng ký ngay để bắt đầu đặt câu hỏi và trả lời</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition">
                    Đăng ký miễn phí
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
