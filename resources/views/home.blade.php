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

    <!-- Список статей -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @include('components.articles-list', ['articles' => $articles])
        </div>

        <!-- Пагинация -->
        @include('components.pagination', ['paginator' => $articles])
    </main>
@endsection
