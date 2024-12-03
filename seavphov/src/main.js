import { createApp } from 'vue'
import './style.css'
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


const app = createApp(App)

app.use(router);
app.use(store);
app.use(Toast, {
    position: POSITION.BOTTOM_RIGHT
});
app.use(VueCookies)
app.component('EasyDataTable', Vue3EasyDataTable);

VueCookies.config('30d', '', '', true);
store.dispatch("setUserFromCookies");
app.mount("#app");