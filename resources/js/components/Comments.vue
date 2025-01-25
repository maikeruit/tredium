<template>
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Комментарии ({{ totalCommentsCount }})</h2>

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

    computed: {
        totalCommentsCount() {
            const countReplies = comments => comments.reduce((total, comment) => 
                total + 1 + (comment.replies?.length ? countReplies(comment.replies) : 0), 0);
            
            return countReplies(this.comments);
        }
    },

    methods: {
        handleCommentAdded(comment) {
            this.comments.unshift({ ...comment, replies: [] })
        },

        handleReplyAdded(reply) {
            const parentComment = this.findComment(reply.parent_id)
            if (parentComment) {
                parentComment.replies = parentComment.replies || []
                parentComment.replies.push(reply)
            }
        },

        findComment(id) {
            const findInComments = comments => comments.find(comment => 
                comment.id === id || (comment.replies && findInComments(comment.replies))
            )
            return findInComments(this.comments)
        }
    }
}
</script>
