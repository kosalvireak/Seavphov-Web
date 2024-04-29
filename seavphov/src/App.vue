

<template>
  <div
    class="d-flex-center flex-column bg-white m-0 p-0"
    style="min-height: 100vh; width: 100%"
  >
    <NavBar />

    <main class="container d-flex-center m-0 p-0 mt-3">
      <router-view />
    </main>

    <Footer />
  </div>
</template>

<script>
import NavBar from "../src/components/Navbar.vue";
import Footer from "../src/components/Footer.vue";

export default {
  name: "App",
  components: { NavBar, Footer },
};
</script>

<style scoped>
.loginPage {
  background-image: url(/img/login_background.png);
  background-size: cover;
}
</style>