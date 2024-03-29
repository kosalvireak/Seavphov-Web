

<template>
  <div
    class="d-flex flex-column bg-success-subtle m-0 p-0"
    style="min-height: 100vh"
  >
    <div style="width: 100%; min-height: 95%; margin-bottom: 23rem">
      <div v-if="isLogin">
        <NavBar />
      </div>

      <main class="container mt-3" v-if="isLogin">
        <router-view />
      </main>
    </div>
    <div style="height: 5%; position: relative; bottom: 0px">
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
  computed: {
    isLogin() {
      // This funtion use to check if the user stay in login or signup page thus we hide Navbar
      if (this.$route.name == "login" || this.$route.name == "signup") {
        return false;
      } else {
        return true;
      }
    },
  },
};
</script>

<style>
.loginPage {
  background-image: url(/img/login_background.png);
  background-size: cover;
}
</style>