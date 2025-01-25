<template>
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Комментарии ({{ comments.length }})</h2>

        <!-- Форма добавления комментария -->
        <div class="mb-8">
            <comment-form
                :article-id="articleId"
                @comment-added="handleCommentAdded"
            />
        </div>

        <!-- Список комментариев -->
        <div class="space-y-6">
            <comment-item
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :article-id="articleId"
                @reply-added="handleReplyAdded"
            />
        </div>
    </div>
</template>

<script>
import CommentForm from './CommentForm.vue'
import CommentItem from './CommentItem.vue'

export default {
    components: {
        CommentForm,
        CommentItem
    },

    props: {
        articleId: {
            type: Number,
            required: true
        },
        initialComments: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            comments: this.initialComments
        }
    },

    methods: {
        handleCommentAdded(comment) {
            this.comments.unshift(comment)
        },

        handleReplyAdded(reply) {
            const parentComment = this.findComment(this.comments, reply.parent_id)

            if (parentComment) {

                if (!parentComment.replies) {
                    parentComment.replies = []
                }

                parentComment.replies.push(reply)
            }
        },

        findComment(comments, id) {
            for (let comment of comments) {

                if (comment.id === id) {
                    return comment
                }

                if (comment.replies) {
                    const found = this.findComment(comment.replies, id)

                    if (found) return found
                }
            }

            return null
        }
    }
}
</script>
