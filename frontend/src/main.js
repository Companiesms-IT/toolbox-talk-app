import { createApp } from "vue";
import "./style.css";
import axios from "./router/axios";
import router from "./router";
import App from "./App.vue";
import VueVideoPlayer from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import "videojs-youtube";
import { GlobalWorkerOptions } from "vue-pdf-embed/dist/index.essential.mjs";
import PdfWorker from "pdfjs-dist/build/pdf.worker.mjs?url";

GlobalWorkerOptions.workerSrc = PdfWorker;

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.use(VueVideoPlayer);
app.mount("#app");
