<script>
import { RouterView } from "vue-router";
import RequireSigninPopup from "../components/RequireSigninPopup.vue";
import UserNavbar from "../components/UserNavbar.vue";
import NotificationSideBar from "../components/notification/NotificationSideBar.vue";
export default {
  name: "UserLayout",
  components: {
    RouterView,
    UserNavbar,
    NotificationSideBar,
    RequireSigninPopup,
  },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <UserNavbar />
    <RouterView class="container-xl" />
    <RequireSigninPopup />
  </div>
</template>

<style scoped></style>
