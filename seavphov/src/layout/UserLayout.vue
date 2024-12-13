<script>
import { RouterView } from "vue-router";
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import UserNavbar from "../components/UserNavbar.vue";
export default {
  name: "UserLayout",
  components: { RouterView, Navbar, Footer, UserNavbar },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <!-- <Navbar /> -->
    <UserNavbar />
    <!-- <RouterView /> -->
    <Footer />
  </div>
</template>

<style scoped>
</style>
