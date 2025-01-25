@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-6">
    <div class="flex gap-2">
        <aside class="flex-initial w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Теги</h2>

                <div class="gap-2">
                    @foreach($tags as $tag)
                        <a href="#" class="px-3 py-1 mb-2 inline-block bg-gray-100 hover:bg-gray-200 rounded-full text-sm">
                            {{ $tag->name }} <span class="text-gray-500">({{ $tag->articles_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <main class="flex-initial w-auto ml-10">
            <h1 class="text-3xl font-bold mb-6">Статьи</h1>

            <div class="space-y-6">
                @foreach($articles as $article)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($article->cover_image)
                            <img src="{{ $article->cover_image }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-48 object-cover">
                        @endif

                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2">{{ $article->title }}</h2>

                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($article->content, 200) }}
                            </p>

                            <div class="flex items-center text-sm text-gray-500">
                                <span class="flex items-center mr-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $article->views->count ?? 0 }}
                                </span>

                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ $article->likes->count ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($articles->hasPages())
                <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
                    @if ($articles->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md">
                        Назад
                    </span>
                    @else
                        <a href="{{ $articles->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                            Назад
                        </a>
                    @endif

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
    </div>
</div>
@endsection
