<template>
    <form @submit.prevent="submitForm" class="mb-4 space-y-4">
        <div>
            <label :for="'subject-' + formId" class="block text-sm font-medium text-gray-700 mb-1">
                Тема комментария
            </label>
            <input
                :disabled="isSubmitting"
                type="text"
                v-model="form.subject"
                :id="'subject-' + formId"
                class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.subject }"
            >
            <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject[0] }}</p>
        </div>

        <div>
            <label :for="'content-' + formId" class="block text-sm font-medium text-gray-700 mb-1">
                {{ isReply ? 'Ваш ответ' : 'Ваш комментарий' }}
            </label>
            <textarea
                :disabled="isSubmitting"
                v-model="form.content"
                :id="'content-' + formId"
                :rows="isReply ? 3 : 4"
                class="p-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                :class="{ 'border-red-500': errors.content }"
                required
            ></textarea>
            <p v-if="errors.content" class="mt-1 text-sm text-red-600">{{ errors.content[0] }}</p>
        </div>

        <div>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    :disabled="isSubmitting"
            >
                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isReply ? 'Отправить' : 'Отправить комментарий' }}
            </button>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        articleId: {
            type: Number,
            required: true
        },
        parentId: {
            type: Number,
            default: null
        },
        isReply: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            form: {
                subject: '',
                content: '',
                parent_id: this.parentId
            },
            errors: {},
            isSubmitting: false,
            formId: this.parentId || 'new'
        }
    },

    methods: {
        async submitForm() {
            if (this.isSubmitting) return

            this.isSubmitting = true
            this.errors = {}

            try {
                const response = await axios.post(`/articles/${this.articleId}/comments`, this.form)
                this.$emit('comment-added', response.data)
                this.form.subject = ''
                this.form.content = ''
            } catch (error) {
                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors
                }
            } finally {
                this.isSubmitting = false
            }
        }
    }
}
</script>
