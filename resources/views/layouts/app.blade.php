<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тредиум</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gray-100">
    <!-- Навигация -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">                
                    <a href="/" class="text-2xl font-bold text-gray-800">Тредиум</a>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-gray-900">Главная</a>
                    <a href="{{ route('articles.catalog') }}" class="text-gray-600 hover:text-gray-900">Каталог статей</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Контент -->
    @yield('content')

    <!-- Футер -->
    <footer class="bg-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-600">
                Тредиум © 2025
            </div>
        </div>
    </footer>
</body>
</html>
