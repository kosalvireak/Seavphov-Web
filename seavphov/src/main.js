import { createApp } from "vue";

// css
import "./style.css";
import "./assets/reset.css";
import "vue-toastification/dist/index.css";
import "../node_modules/flowbite-vue/dist/index.css";
import "vue3-easy-data-table/dist/style.css";
import "mdb-vue-ui-kit/css/mdb.min.css";

// js
import "mdb-vue-ui-kit/js/mdb.es.min.js";

// plugin
import "flowbite";
import VueCookies from "vue-cookies";
import Vue3EasyDataTable from "vue3-easy-data-table";

// custom
import App from "./App.vue";
import router from "./router/index";
import store from "./utils/store";
import { RouterMixin } from "./utils/routerUtils";
import { DateMixin } from "./utils/dateMixin";
import toastPlugin from "./utils/toastPlugin";
import mobileUtils from "./utils/mobileUtils";

// component
import { FwbButton } from "flowbite-vue";
import Loader from "./components/common/Loader.vue";
import BackRoute from "./components/common/BackRoute.vue";
import Dropdown from "./components/common/Dropdown.vue";
import LoadingButton from "./components/common/LoadingButton.vue";

const app = createApp(App);

// global variable
app.config.globalProperties.isMobile = mobileUtils.isMobile();
app.config.globalProperties.logoUrl =
  "https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Seavphov%20Logo-2.png";

// global component
app.component("EasyDataTable", Vue3EasyDataTable);
app.component("Loader", Loader);
app.component("FwbButton", FwbButton);
app.component("BackRoute", BackRoute);
app.component("Dropdown", Dropdown);
app.component("LoadingButton", LoadingButton);

// global mixin
app.mixin(RouterMixin);
app.mixin(DateMixin);

// use plugin
app.use(router);
app.use(store);
app.use(toastPlugin);
app.use(VueCookies);

// configuration
VueCookies.config("30d", "", "", true);
store.dispatch("setUserFromCookies");

// mounted
app.mount("#app");
