import './bootstrap';
import { createApp } from 'vue'
import Comments from './components/Comments.vue'
import LikeCounter from './components/LikeCounter.vue'

const app = createApp({})
app.component('comments', Comments)
app.component('like-counter', LikeCounter)
app.mount('#app')
