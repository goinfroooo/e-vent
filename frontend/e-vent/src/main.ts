import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import './style.scss'
import Router from "./router.ts"
import { createPinia } from 'pinia'

const pinia = createPinia()


createApp(App).use(pinia).use(Router).mount('#app')
