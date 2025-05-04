<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Hệ thống Q&A</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="auth-layout">
    <header>
        @include('layouts.partials.navbar')
    </header>

    <!-- Main Content -->
    <div class="main-wrapper">

        <!-- Page Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <footer>
        @include('layouts.partials.footer', [
            'title' => 'Hệ thống Q&A',
            'class' => 'mt-auto',
            'links' => [
                'questions' => '#',
                'tags' => '#',
                'faq' => '#'
            ],
            'socials' => [
                ['icon' => 'fab fa-facebook-f', 'url' => '#'],
                ['icon' => 'fab fa-github', 'url' => '#'],
                ['icon' => 'fas fa-envelope', 'url' => '#']
            ],
            'copyright' => 'Hệ thống Q&A'
        ])
    </footer>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    @stack('scripts')
</body>

</html>
