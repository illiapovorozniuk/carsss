import { createApp } from "vue";
import store from "./store";
import "./style.css";
import App from "./App.vue";
import "./index.css";
import router from "./router";

createApp(App).use(store).use(router).mount("#app");
