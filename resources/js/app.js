import "./bootstrap";
import "bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";

import UsersView from "./components/UsersView.vue";
const app = createApp({});

app.component("users-view", UsersView);
const mountedApp = app.mount("#app");
