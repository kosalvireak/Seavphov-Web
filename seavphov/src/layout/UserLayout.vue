<script>
import { RouterView } from "vue-router";
import RequireSigninPopup from "../components/RequireSigninPopup.vue";
import UserNavbar from "../components/UserNavbar.vue";
import NotificationSideBar from "../components/notification/NotificationSideBar.vue";
import Footer from "../components/Footer.vue";
export default {
  name: "UserLayout",
  components: {
    RouterView,
    UserNavbar,
    NotificationSideBar,
    RequireSigninPopup,
    Footer,
  },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <UserNavbar />
    <RouterView class="container-xl" />
    <Footer class="mt-24" />
    <RequireSigninPopup />
  </div>
</template>

<style scoped></style>
