<script>
import { RouterView } from "vue-router";
import Footer from "../components/Footer.vue";
import UserNavbar from "../components/UserNavbar.vue";
export default {
  name: "UserLayout",
  components: { RouterView, Footer, UserNavbar },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column w-100">
    <UserNavbar />
    <RouterView />
    <Footer />
  </div>
</template>

<style scoped></style>
