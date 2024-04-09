

<template>
  <div
    class="d-flex flex-column bg-success-subtle m-0 p-0"
    style="min-height: 100vh; width: 100%"
  >
    <div>
      <NavBar />
    </div>

    <main class="container mt-3">
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

<style>
.container {
  flex: 1;
}
.loginPage {
  background-image: url(/img/login_background.png);
  background-size: cover;
}
</style>