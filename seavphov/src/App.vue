

<template>
  <div
    class="d-flex flex-column bg-success-subtle m-0 p-0"
    style="min-height: 100vh"
  >
    <div style="width: 100%; min-height: 95%">
      <div>
        <NavBar />
      </div>

      <main class="container mt-3">
        <router-view />
      </main>
    </div>
    <div style="height: 5%; position: relative; bottom: 0px; margin-top: 15rem">
      <Footer />
    </div>
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
.loginPage {
  background-image: url(/img/login_background.png);
  background-size: cover;
}
</style>