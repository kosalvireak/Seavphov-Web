<script>
import { RouterView } from "vue-router";
import Footer from "../components/Footer.vue";
import UserNavbar from "../components/UserNavbar.vue";
import HomeNavigation from "../components/home/HomeNavigation.vue";
export default {
  name: "UserLayout",
  components: { RouterView, Footer, UserNavbar, HomeNavigation },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <UserNavbar />
    <HomeNavigation />
    <RouterView />
    <Footer class="mt-8" />
  </div>
</template>

<style scoped></style>
