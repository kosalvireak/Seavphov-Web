<script>
import { RouterView } from "vue-router";
import UserNavbar from "../components/UserNavbar.vue";
import NotificationSideBar from "../components/notification/NotificationSideBar.vue";
export default {
  name: "UserLayout",
  components: { RouterView, UserNavbar, NotificationSideBar },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <UserNavbar />
    <RouterView class="container-xl" />
  </div>
</template>

<style scoped></style>
