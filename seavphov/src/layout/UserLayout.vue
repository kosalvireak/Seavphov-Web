<script>
import { RouterView } from "vue-router";
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
export default {
  name: "UserLayout",
  components: { RouterView, Navbar, Footer },
};
</script>

<template>
  <div class="UserLayout flex-center flex-column">
    <Navbar />
    <RouterView />
    <Footer />
  </div>
</template>

<style scoped>
</style>
