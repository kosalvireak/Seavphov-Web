import { createApp } from "vue";

// Third-party CSS imports
import "vue-toastification/dist/index.css";
import "../node_modules/flowbite-vue/dist/index.css";
import "vue3-easy-data-table/dist/style.css";
import "mdb-vue-ui-kit/css/mdb.min.css";

// Custom CSS (including Tailwind CSS)
import "./assets/style/style.css";

// js
import "mdb-vue-ui-kit/js/mdb.es.min.js";

// plugin
import "flowbite";
import VueCookies from "vue-cookies";
import Vue3EasyDataTable from "vue3-easy-data-table";

// custom js
import App from "./App.vue";
import router from "./router/index";
import store from "./utils/store";
import { RouterMixin } from "./utils/routerUtils";
import { UtilsMixin } from "./utils/utilsMixin";
import { DateMixin } from "./utils/dateMixin";
import toastPlugin from "./services/toastPlugin";
import { signInState, signInMethods } from "./utils/requireSignin";
import Seavphov from "./services/seavphov.js";

// socket
import "./bootstrap";
import "./services/websocket/echo";

// component
import {
  FwbButton,
  FwbModal,
  FwbAvatar,
  FwbBadge,
  FwbProgress,
  FwbDropdown,
  FwbInput
} from "flowbite-vue";
import Loader from "./components/common/Loader.vue";
import TinyLoader from "./components/common/TinyLoader.vue";
import BackRoute from "./components/common/BackRoute.vue";
import Dropdown from "./components/common/Dropdown.vue";
import LoadingButton from "./components/common/LoadingButton.vue";
import ImageUpload from "./components/common/ImageUpload.vue";
import PdfUpload from "./components/common/PdfUpload.vue";
import HomeNavigation from "./components/home/HomeNavigation.vue";
import Info from "./components/common/Info.vue";

const app = createApp(App);

// global variable
app.config.globalProperties.$signinMethods = signInMethods;
app.config.globalProperties.$signinState = signInState;

// global component
app.component("EasyDataTable", Vue3EasyDataTable);
app.component("FwbButton", FwbButton);
app.component("FwbModal", FwbModal);
app.component("FwbAvatar", FwbAvatar);
app.component("Badge", FwbBadge);
app.component("Progress", FwbProgress);
app.component("FwbDropdown", FwbDropdown);
app.component("FwbInput", FwbInput);

app.component("Loader", Loader);
app.component("TinyLoader", TinyLoader);
app.component("BackRoute", BackRoute);
app.component("Dropdown", Dropdown);
app.component("LoadingButton", LoadingButton);
app.component("ImageUpload", ImageUpload);
app.component("PdfUpload", PdfUpload);
app.component("HomeNavigation", HomeNavigation);
app.component("Info", Info);

// global mixin
app.mixin(RouterMixin);
app.mixin(DateMixin);
app.mixin(UtilsMixin);

// use plugin
app.use(router);
app.use(store);
app.use(toastPlugin);
app.use(VueCookies);

// configuration
VueCookies.config("30d", "", "", true);
store.dispatch("setUserFromCookies");

// bind globally
window.Seavphov = Seavphov;

// mounted
app.mount("#app");
