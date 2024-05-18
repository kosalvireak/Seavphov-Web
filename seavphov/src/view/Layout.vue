

<template>
  <section>
    <div
      v-if="!isAdminRoute"
      class="d-flex-center flex-column bg-white m-0 p-0"
    >
      <Nav />

      <div
        class="d-flex-center m-0 p-0 container align-items-start"
        style="max-width: 1980px; min-height: 100vh"
      >
        <router-view class="mt-3" />
      </div>

      <Footer />
    </div>
    <Dashboard v-else />
  </section>
</template>
  
  <script>
import Nav from "../components/Nav.vue";
import Footer from "../components/Footer.vue";
import Dashboard from "./admin/Dashboard.vue";

export default {
  name: "Layout",
  components: { Footer, Nav, Dashboard },
  data() {
    return {
      isAdminRoute: false,
    };
  },
  mounted() {
    if (this.$route.name) {
      const admin = this.$route.name.startsWith("admin");
      if (admin) {
        this.isAdminRoute = true;
      }
    }
  },
};
</script>
  
  <style scoped>
.loginPage {
  background-image: url(/img/login_background.png);
  background-size: cover;
}
</style>