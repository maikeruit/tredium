@extends('layouts.app')

@section('content')
    <!-- Hero секция -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-6xl font-extrabold text-gray-900 sm:text-7xl">
                    Успех
                </h1>
                <p class="mt-3 max-w-md mx-auto text-xl text-gray-500 sm:text-2xl md:mt-5 md:max-w-3xl">
                    Для молодых и успешных
                </p>
            </div>
        </div>
    </div>

    <!-- Основной контент -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $article->title }}
                        </h2>
                        <div class="text-gray-600 line-clamp-3">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex space-x-4 text-sm text-gray-500">
                                <span>{{ $article->views->count ?? 0 }}</span>
                                <span>{{ $article->likes->count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($articles->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
                {{-- Previous Page Link --}}
                @if ($articles->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md">
                        Назад
                    </span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                        Назад
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                    @if ($page == $articles->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-gray-300">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                        Вперед
                    </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md">
                        Вперед
                    </span>
                @endif
            </nav>
        @endif
    </main>
@endsection
