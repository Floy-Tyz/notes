import { createApp } from 'vue'
import App from './App.vue'
import router from "@/routes";
import store from "@/store/store";

store.subscribe((mutation, state)=> {
    localStorage.setItem('store', JSON.stringify(state))
})

createApp(App).use(router).use(store).mount('#app')

// const app = createApp(App)
// app.use(router)
// app.mount('#app')
