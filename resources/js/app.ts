import './bootstrap'
import '@/assets/main.css'
import 'vue-base-tooltip/style.css'
import '@fontsource/clear-sans/300.css'
import '@fontsource/clear-sans/400.css'
import '@fontsource/clear-sans/500.css'
import '@fontsource/clear-sans/700.css'
import '@/utils/Validation'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueBaseTooltip from 'vue-base-tooltip'
import App from './App.vue'
import router from './router'
import VueMitter from '@nguyenshort/vue3-mitt'

const app = createApp(App)

app.config.errorHandler = (err, instance, info) => {
  console.log('ERROR HANDLER', err, instance, info)
}

app.use(createPinia())
app.use(VueBaseTooltip)
app.use(VueMitter)
app.use(router)
app.mount('#app')
