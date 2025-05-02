<div class="mb-8">
    <h4 class="text-lg font-bold text-gray-800 mb-4">Thống kê cộng đồng</h4>
    <ul class="space-y-3 text-gray-600">
        <li class="flex justify-between">
            <span>Thành viên</span>
            <span class="font-semibold">{{ number_format($stats['users']) }}</span>
        </li>
        <li class="flex justify-between">
            <span>Câu hỏi</span>
            <span class="font-semibold">{{ number_format($stats['questions']) }}</span>
        </li>
        <li class="flex justify-between">
            <span>Câu trả lời</span>
            <span class="font-semibold">{{ number_format($stats['answers']) }}</span>
        </li>
    </ul>
</div>

<div class="border-t border-gray-200 pt-6">
    <h4 class="text-lg font-bold text-gray-800 mb-4">Tại sao tham gia?</h4>
    <ul class="space-y-4 text-gray-600">
        <li class="flex items-start">
            <svg class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Đặt câu hỏi và nhận câu trả lời từ cộng đồng</span>
        </li>
        <!-- Thêm các lý do khác tương tự -->
    </ul>
</div>
