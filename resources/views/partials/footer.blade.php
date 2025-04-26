<footer class="bg-gray-800 text-white py-12 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-semibold mb-4">About DevQ&A</h3>
                <p class="text-gray-300 text-sm">
                    DevQ&A is a community-driven question and answer platform for developers. Ask questions, find answers, and level up your coding skills.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                {{-- <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="{{ route('questions.index') }}" class="hover:text-blue-400">Questions</a></li>
                    <li><a href="{{ route('tags.index') }}" class="hover:text-blue-400">Tags</a></li>
                    <li><a href="{{ route('users.index') }}" class="hover:text-blue-400">Users</a></li>
                    <li><a href="{{ route('questions.create') }}" class="hover:text-blue-400">Ask Question</a></li>
                </ul> --}}
            </div>

            <!-- Policies -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Policies</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-blue-400">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-blue-400">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-blue-400">Code of Conduct</a></li>
                    <li><a href="#" class="hover:text-blue-400">Cookie Policy</a></li>
                </ul>
            </div>

            <!-- Social & Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                <div class="flex space-x-4 mb-4">
                    <a href="#" class="text-gray-300 hover:text-blue-400">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-blue-400">
                        <i class="fab fa-github fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-blue-400">
                        <i class="fab fa-discord fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-blue-400">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                </div>
                <p class="text-sm text-gray-300">
                    <i class="fas fa-envelope mr-2"></i> contact@devqa.com
                </p>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} DevQ&A. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white text-sm">Help Center</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm">Feedback</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
