@props(['comment', 'article', 'level' => 0])

<div class="{{ $level > 0 ? 'ml-8' : '' }}">
    <div class="mb-2 bg-gray-50 p-4 rounded-lg">
        <h4 class="font-medium text-gray-900 mb-2">{{ $comment->subject }}</h4>
        <p class="text-gray-800">{{ $comment->content }}</p>
        <div class="flex items-center justify-between mt-2">
            <span class="text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }}</span>
            <button
                onclick="toggleReplyForm('comment-{{ $comment->id }}')"
                class="text-sm text-blue-600 hover:text-blue-800"
            >
                Ответить
            </button>
        </div>
    </div>

    <!-- Форма ответа на комментарий -->
    <div id="comment-{{ $comment->id }}" class="hidden mt-4">
        <x-comment-form :article="$article" :parent-id="$comment->id" :is-reply="true" />
    </div>

    <!-- Рекурсивный вывод ответов -->
    @foreach($comment->replies as $reply)
        <x-comment-item :comment="$reply" :article="$article" :level="$level + 1" />
    @endforeach
</div>
