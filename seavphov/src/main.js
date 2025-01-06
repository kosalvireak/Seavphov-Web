import { createApp } from "vue";
import "./style.css";
import "./assets/reset.css";
import "flowbite";
import { FwbButton } from "flowbite-vue";
import "../node_modules/flowbite-vue/dist/index.css";
import "mdb-vue-ui-kit/css/mdb.min.css";
import "mdb-vue-ui-kit/js/mdb.es.min.js";
import App from "./App.vue";
import router from "./router/index";
import store from "./utils/store";
import "vue-toastification/dist/index.css";
import VueCookies from "vue-cookies";
import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

import { RouterMixin } from "./utils/routerUtils";
import { DateMixin } from "./utils/dateMixin";
import toastPlugin from "./utils/toastPlugin";

import Loader from "./components/common/Loader.vue";
import BackRoute from "./components/common/BackRoute.vue";

const app = createApp(App);

// Bind global variable //
app.config.globalProperties.$logoUrl =
  "https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/seavphov_logo.png";

// Bind global component //
app.component("EasyDataTable", Vue3EasyDataTable);
app.component("Loader", Loader);
app.component("FwbButton", FwbButton);
app.component("BackRoute", BackRoute);

app.use(router);
app.use(store);
app.use(toastPlugin);
app.use(VueCookies);

app.mixin(RouterMixin);
app.mixin(DateMixin);

VueCookies.config("30d", "", "", true);
store.dispatch("setUserFromCookies");
app.mount("#app");
