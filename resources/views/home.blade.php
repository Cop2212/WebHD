
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Action button giữ nguyên -->

                <!-- Questions list -->
                <div id="questions-container">
                    @include('partials.questions', ['questions' => $questions])
                </div>
            </div>

            <!-- Sidebar -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm"
            x-data="{
                selectedTags: @json($selectedTags ?? []),
                loading: false,

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('tags')) {
                        this.selectedTags = urlParams.get('tags').split(',');
                    }
                },

                async filterQuestions(page = 1) {
    this.loading = true;
    try {
        const query = new URLSearchParams({
            tags: this.selectedTags.join(','),
            page: page
        });

        const response = await fetch(`/questions/filter?${query.toString()}`);
        const data = await response.json();

        document.getElementById('questions-container').innerHTML = data.html;

        history.pushState(null, null,
            this.selectedTags.length > 0
                ? `?tags=${this.selectedTags.join(',')}&page=${page}`
                : `?page=${page}`);
    } catch (error) {
        console.error('Error:', error);
    } finally {
        this.loading = false;
    }
},


                clearFilters() {
                    this.selectedTags = [];
                    this.filterQuestions();
                },

                handlePagination(event) {
    const target = event.target.closest('a');
    if (!target) return;

    const url = new URL(target.href);
    const page = url.searchParams.get('page') || 1;
    this.filterQuestions(page);
},
            }">
                <!-- Phần hiển thị tags -->
                <h4 class="text-md font-bold text-gray-800 dark:text-white mb-2">Popular Tags</h4>
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($popularTags as $tag)
                        <button
                            @click="selectedTags.includes('{{ $tag->name }}')
                                ? selectedTags = selectedTags.filter(t => t !== '{{ $tag->name }}')
                                : selectedTags.push('{{ $tag->name }}')"
                            :class="{
                                'bg-blue-600 text-white': selectedTags.includes('{{ $tag->name }}'),
                                'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200': !selectedTags.includes('{{ $tag->name }}')
                            }"
                            class="text-sm px-3 py-1 rounded-full transition-colors"
                            :disabled="loading"
                        >
                            #{{ $tag->name }}
                            <span class="text-xs opacity-75 ml-1">{{ $tag->questions_count }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Nút áp dụng lọc -->
                <button
                    @click="filterQuestions()"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                    x-show="selectedTags.length > 0"
                    :disabled="loading"
                >
                    <span x-show="!loading">Áp dụng lọc (<span x-text="selectedTags.length"></span>)</span>
                    <span x-show="loading">Đang tải...</span>
                </button>

                <!-- Nút xóa tất cả lọc -->
                <button
                    @click="clearFilters()"
                    class="px-4 py-2 ml-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                    x-show="selectedTags.length > 0"
                    :disabled="loading"
                >
                    Xóa lọc
                </button>

                <!-- Phần Site Stats giữ nguyên -->
                <h4 class="text-md font-bold text-gray-800 dark:text-white mb-2">Site Stats</h4>
                <ul class="text-sm text-gray-600 dark:text-gray-300">
                    <li>Total Users: {{ $userCount }}</li>
                    <li>Total Questions: {{ $questionCount }}</li>
                    <li>Total Answers: {{ $answerCount }}</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();

                const link = e.target.closest('.pagination a');
                const url = new URL(link.href);
                const page = url.searchParams.get('page');

                // Gọi Alpine function filterQuestions với page
                let sidebar = document.querySelector('[x-data]');
                if (sidebar && sidebar.__x) {
                    sidebar.__x.$data.filterQuestions(Number(page));
                }
            }
        });
    });
</script>

