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
                <!-- Questions Container -->
                <div id="questions-container" wire:ignore>
                    @include('partials.questions', ['questions' => $questions])
                </div>

                <!-- Loading Indicator -->
                <div x-show="loading" x-cloak class="text-center py-4">
                    <svg class="animate-spin h-5 w-5 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div id="pagination-container" class="mt-4" wire:ignore>
                    {{ $questions->withQueryString()->links() }}
                </div>
            </div>

            <!-- Sidebar Alpine Component -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm"
                 x-data="sidebar()"
                 x-init="init()"
                 wire:ignore.self>

                <!-- Tag Filter UI -->
                <h4 class="text-md font-bold mb-2">Popular Tags</h4>
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($popularTags as $tag)
                        <button
                            @click="toggleTag('{{ $tag->name }}')"
                            :class="{
                                'bg-blue-600 text-white': selectedTags.includes('{{ $tag->name }}'),
                                'bg-gray-200 dark:bg-gray-700': !selectedTags.includes('{{ $tag->name }}')
                            }"
                            class="text-sm px-3 py-1 rounded-full">
                            #{{ $tag->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 mb-6" x-show="selectedTags.length > 0">
                    <button @click="filterQuestions()"
                            :disabled="loading"
                            class="px-4 py-2 bg-green-600 text-white rounded">
                        <span x-show="!loading">Apply Filters</span>
                        <span x-show="loading">Loading...</span>
                    </button>

                    <button @click="clearFilters()"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>


function sidebar() {
    return {
        selectedTags: @json($selectedTags ?? []),
        loading: false,

        // Khởi tạo component
        init() {

            if (typeof Livewire !== 'undefined') {
        Livewire.hook('commit', ({ component }) => {
            if (component.id === this.$wire.__instance.id) {
                this.syncFromUrl();
            }
        });
    }
            this.syncFromUrl();
            window.addEventListener('popstate', () => this.syncFromUrl());
            console.log('Alpine sidebar initialized');
        },

        // Xử lý toggle tag
        toggleTag(tagName) {
            if (this.selectedTags.includes(tagName)) {
                this.selectedTags = this.selectedTags.filter(t => t !== tagName);
            } else {
                this.selectedTags.push(tagName);
            }
            console.log('Selected tags:', this.selectedTags);
        },

        // Đồng bộ state từ URL
        syncFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            this.selectedTags = urlParams.has('tags')
                ? urlParams.get('tags').split(',')
                : [];
        },

        // Lọc câu hỏi
        async filterQuestions(page = 1) {
    this.loading = true;
    try {
        const query = new URLSearchParams();

        if (this.selectedTags.length > 0) {
            query.append('tags', this.selectedTags.join(','));
        }

        if (page > 1) {
            query.append('page', page);
        }

        // Sử dụng URL gốc (/) thay vì /questions/filter
        const url = `/?${query.toString()}`;
        console.log('Fetching:', url);

        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        // Cập nhật DOM
        document.getElementById('questions-container').innerHTML = data.html;

        const paginationContainer = document.getElementById('pagination-container');
        if (paginationContainer && data.pagination) {
            paginationContainer.innerHTML = data.pagination;
        }

        // Cập nhật URL nhưng giữ nguyên path gốc
        this.updateUrl(page);
    } catch (error) {
        console.error('Filter error:', error);
    } finally {
        this.loading = false;
    }
},

        // Cập nhật URL
        updateUrl(page = 1) {
    const params = new URLSearchParams();

    if (this.selectedTags.length > 0) {
        params.set('tags', this.selectedTags.join(','));
    }

    params.set('page', page > 1 ? page : ''); // Xóa page nếu = 1

    // Luôn giữ nguyên pathname gốc
    const newUrl = `${window.location.pathname}?${params.toString()}`.replace(/\?$/, '');

    history.pushState(null, '', newUrl);
    console.log('URL updated:', newUrl);
},

        // Xóa bộ lọc
        clearFilters() {
            this.selectedTags = [];
            this.filterQuestions();
        }
    };
}

    // Global event handlers
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
    const paginationLink = e.target.closest('.pagination a');
    if (!paginationLink) return;

    e.preventDefault();
    const alpineComponent = document.querySelector('[x-data]')?.__x?.$data;

    if (!alpineComponent) {
        console.error('Alpine component not found');
        return;
    }

    // Lấy page từ href nhưng bỏ qua path không cần thiết
    const page = new URL(paginationLink.href).searchParams.get('page') || 1;
    alpineComponent.filterQuestions(page);
});

// Nếu dùng Livewire, thêm phần này
if (typeof Livewire !== 'undefined') {
    Livewire.hook('message.processed', () => {
        Alpine.discoverUninitializedComponents(el => Alpine.initializeComponent(el));
    });
}
    });
</script>
