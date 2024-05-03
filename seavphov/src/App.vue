

<template>
  <div
    class="d-flex-center flex-column bg-white m-0 p-0"
    style="max-height: 4000px"
  >
    <NavBar />

    <main
      class="d-flex-center m-0 p-0 container mt-3"
      style="max-width: 1980px"
    >
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