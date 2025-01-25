@extends('layouts.app')

@section('content')
<article class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-4">{{ $article->title }}</h1>

    <!-- Счетчики -->
    <div class="flex items-center gap-4 text-gray-600 mb-6">
        <span class="flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            {{ $article->views->count }}
        </span>
        <span class="flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            {{ $article->likes->count }}
        </span>
    </div>

    <!-- Теги -->
    @if($article->tags->count())
    <div class="flex gap-2 mb-8">
        @foreach($article->tags as $tag)
            <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}" 
               class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-sm hover:bg-gray-300">
                {{ $tag->name }}
            </a>
        @endforeach
    </div>
    @endif

    <!-- Изображение -->
    @if($article->cover_image)
    <img src="{{ $article->cover_image }}"
         alt="{{ $article->title }}"
         class="w-full h-96 object-cover rounded-lg mb-8">
    @endif

    <!-- Контент -->
    <div class="prose max-w-none">
        {!! nl2br(e($article->content)) !!}
    </div>

    <!-- Форма отправки комментария -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Комментарии ({{ $article->comments->count() }})</h2>

        <div class="mb-8">
            <x-comment-form :article="$article" />
        </div>

        <!-- Комментарии -->
        @foreach($article->comments->whereNull('parent_id') as $comment)
            <x-comment-item :comment="$comment" :article="$article" />
        @endforeach
    </div>
</article>

<script>
function toggleReplyForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.classList.toggle('hidden');
    }
}
</script>

@endsection
