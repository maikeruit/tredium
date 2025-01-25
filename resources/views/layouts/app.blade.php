<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тредиум</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gray-100">
    <div id="app">
        <!-- Навигация -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold text-gray-800">Тредиум</a>
                    </div>
                    <div class="flex items-center space-x-8">
                        <a href="/"
                           class="text-gray-600 hover:text-gray-900 pb-1 border-b-2 {{ request()->is('/') ? 'border-blue-500' : 'border-transparent' }}">
                            Главная
                        </a>
                        <a href="{{ route('articles.index') }}"
                           class="text-gray-600 hover:text-gray-900 pb-1 border-b-2 {{ request()->routeIs('articles.index') ? 'border-blue-500' : 'border-transparent' }}">
                            Каталог статей
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Сообщение об успехе -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Основной контент -->
        @yield('content')
    </div>

    <!-- Футер -->
    <footer class="bg-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-600">
                Тредиум © 2025
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
