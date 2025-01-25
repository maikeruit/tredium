<template>
    <div :class="{ 'ml-8': comment.parent_id }">
        <div class="mb-2 bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-900 mb-2">{{ comment.subject }}</h4>
            <p class="text-gray-800">{{ comment.content }}</p>
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm text-gray-600">{{ comment.created_at_human }}</span>
                <button
                    @click="showReplyForm = !showReplyForm"
                    class="text-sm text-blue-600 hover:text-blue-800"
                >
                    Ответить
                </button>
            </div>
        </div>

        <!-- Форма ответа -->
        <div v-if="showReplyForm" class="mt-4">
            <comment-form
                :article-id="articleId"
                :parent-id="comment.id"
                :is-reply="true"
                @comment-added="handleReplyAdded"
            />
        </div>

        <!-- Вложенные ответы -->
        <div v-if="comment.replies && comment.replies.length > 0">
            <comment-item
                v-for="reply in comment.replies"
                :key="reply.id"
                :comment="reply"
                :article-id="articleId"
                @reply-added="$emit('reply-added', $event)"
            />
        </div>
    </div>
</template>

<script>
import CommentForm from './CommentForm.vue'

export default {
    name: 'CommentItem',

    components: {
        CommentForm
    },

    props: {
        comment: {
            type: Object,
            required: true
        },
        articleId: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            showReplyForm: false
        }
    },

    methods: {
        handleReplyAdded(reply) {
            this.showReplyForm = false
            this.$emit('reply-added', reply)
        }
    }
}
</script> 