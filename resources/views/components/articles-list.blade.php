@foreach($articles as $article)
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($article->cover_image)
            <img src="{{ $article->cover_image }}" alt="{{ $article->title }}"
                 class="w-full h-48 object-cover">
        @endif
        <div class="p-6">
            <a href="{{ route('articles.show', $article) }}">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                    {{ $article->title }}
                </h2>

                <div class="text-gray-600 line-clamp-3 mb-4">
                    {{ Str::limit(strip_tags($article->content), 100) }}
                </div>
            </a>
            <div class="flex items-center text-sm text-gray-500">
                    <span class="flex items-center mr-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $article->views->count ?? 0 }}
                    </span>

                <span class="flex items-center gap-1">
                        <like-counter
                            :article-id="{{ $article->id }}"
                            :initial-likes="{{ $article->likes->count ?? 0 }}"
                        />
                    </span>
            </div>
        </div>
    </article>
@endforeach
