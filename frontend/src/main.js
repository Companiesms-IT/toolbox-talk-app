import { createApp } from 'vue'
import './style.css'
import axios from './router/axios';
import router from './router';
import App from './App.vue'
// import 'bootstrap/dist/css/bootstrap.min.css';
// import '/public/css/all.min.css';
// import '/public/css/style.css';


const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')
