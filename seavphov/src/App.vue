

<template>
  <div
    class="d-flex flex-column bg-success-subtle m-0 p-0"
    style="min-height: 100vh"
  >
    <div v-if="isLogin">
      <NavBar />
    </div>

    <main class="container mt-3" v-if="isLogin">
      <router-view />
    </main>

    <main class="loginPage h-100 w-100" v-if="!isLogin">
      <router-view />
    </main>
  </div>
</template>

<script>
import NavBar from "../src/components/Navbar.vue";
export default {
  name: "App",
  components: { NavBar },
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