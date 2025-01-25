@props(['article', 'parentId' => null, 'isReply' => false])

<form action="{{ route('articles.comments.store', $article) }}" method="POST" class="mb-4 space-y-4">
    @csrf
    @if($parentId)
        <input type="hidden" name="parent_id" value="{{ $parentId }}">
    @endif
    <div>
        <label for="content-{{ $parentId ?? 'new' }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $isReply ? 'Ваш ответ' : 'Ваш комментарий' }}
        </label>
        <textarea
            name="content"
            id="content-{{ $parentId ?? 'new' }}"
            rows="{{ $isReply ? 3 : 4 }}"
            class="p-4   block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required
        >{{ old('content') }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <button type="submit"
            class="inline-flex items-center px-{{ $isReply ? 3 : 4 }} py-{{ $isReply ? 1.5 : 2 }} border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            {{ $isReply ? 'Отправить' : 'Отправить комментарий' }}
        </button>
    </div>
</form>
