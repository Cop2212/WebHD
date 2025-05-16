<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hỏi đáp cộng đồng')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<header>
    @include('layouts.partials.navbar')
</header>

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

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

</body>
</html>
