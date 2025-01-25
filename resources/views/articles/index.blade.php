@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-6">
        <div class="flex gap-2">

            <!-- Правая колонка тегов -->
            <aside class="flex-initial w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Теги</h2>

                    <div class="gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}"
                               class="px-3 py-1 mb-2 inline-block rounded-full text-sm
                           {{ request('tag') == $tag->slug
                              ? 'bg-blue-500 text-white hover:bg-blue-600'
                              : 'bg-gray-100 hover:bg-gray-200' }}">
                                {{ $tag->name }} <span
                                    class="text-{{ request('tag') == $tag->slug ? 'blue-200' : 'gray-500' }}">({{ $tag->articles_count }})</span>
                            </a>
                        @endforeach

                        @if(request()->has('tag'))
                            <div class="mt-4">
                                <a href="{{ route('articles.index') }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm">
                                    ← Сбросить фильтр
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>

            <main class="flex-initial w-auto ml-10">
                <h1 class="text-3xl font-bold mb-6">Статьи</h1>

                <div class="space-y-6">
                    <!-- Список статей -->
                    @include('components.articles-list', ['articles' => $articles])
                </div>

                <!-- Пагинация -->
                @include('components.pagination', ['paginator' => $articles])
            </main>
        </div>
    </div>
@endsection
