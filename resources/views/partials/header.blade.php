<header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h1a1 1 0 0 1 0 2h-3z"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900 hidden md:inline">DevQ&A</span>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="flex-1 max-w-md mx-4 hidden md:block">
                {{-- <form action="{{ route('questions.search') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Search questions..."
                               class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form> --}}
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                {{-- <a href="{{ route('questions.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Questions
                </a> --}}
                {{-- <a href="{{ route('tags.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Tags
                </a> --}}
                {{-- <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Users
                </a> --}}
            </div>

            <!-- Auth Links -->
            <div class="flex items-center">
                @auth
                    <div class="relative ml-3">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('questions.create') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium hidden md:block">
                                Ask Question
                            </a>

                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="hidden md:inline text-gray-700">{{ auth()->user()->name }}</span>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-50">
                                    {{-- <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Your Profile
                                    </a> --}}
                                    {{-- <a href="{{ route('users.questions', auth()->id()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Your Questions
                                    </a> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Sign up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open main menu</span>
                    <i class="fas fa-bars" x-show="!open"></i>
                    <i class="fas fa-times" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="md:hidden bg-white shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Mobile Search -->
            <div class="px-4 py-2">
                {{-- <form action="{{ route('questions.search') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Search questions..."
                               class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form> --}}
            </div>

            {{-- <a href="{{ route('questions.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                Questions
            </a> --}}
            {{-- <a href="{{ route('tags.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                Tags
            </a> --}}
            {{-- <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                Users
            </a> --}}

            @auth
                <a href="{{ route('questions.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">
                    Ask Question
                </a>
                {{-- <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    Your Profile
                </a> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                        Sign out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">
                    Sign up
                </a>
            @endauth
        </div>
    </div>
</header>
