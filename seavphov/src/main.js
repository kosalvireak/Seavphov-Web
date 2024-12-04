import { createApp } from 'vue'
import './style.css'
import './assets/reset.css'
import '../node_modules/flowbite-vue/dist/index.css'
import 'mdb-vue-ui-kit/css/mdb.min.css';

import 'mdb-vue-ui-kit/js/mdb.es.min.js';
import App from './App.vue'
import router from './router/index';
import store from './store/index'
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueCookies from 'vue-cookies';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

import { RouterMixin } from './store/routerUtils';

import Loader from './components/Loader.vue';

const app = createApp(App)
// Bind global variable //
app.config.globalProperties.$logoUrl =
    'https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/seavphov_logo.jpg'

app.use(router);
app.use(store);
app.use(Toast, {
    position: POSITION.BOTTOM_RIGHT
});
app.use(VueCookies)
app.component('EasyDataTable', Vue3EasyDataTable);
app.component('Loader', Loader);


app.mixin(RouterMixin)

VueCookies.config('30d', '', '', true);
store.dispatch("setUserFromCookies");
app.mount("#app");