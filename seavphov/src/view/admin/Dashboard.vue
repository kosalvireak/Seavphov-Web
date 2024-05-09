<template>
  <div
    v-if="isAdmin"
    class="Dashboard container-xl w-100 h-100 row p-0 m-0 mt-0"
  >
    <div class="Dashboard_left col-2 bg-white text-black p-0">
      <LeftSidePanel />
    </div>
    <div class="Dashboard_right col-10 bg-seavphov-light m-0 p-0">
      <AdminNav />
      <component
        :is="renderComponent"
        v-if="showDashboard"
        :key="componentsKey"
      />
      <DashboardOverview v-else />
    </div>
  </div>
</template>
  
  <script>
import Books from "../../components/admin/Books.vue";
import Users from "../../components/admin/Users.vue";
import Banners from "../../components/admin/Banners.vue";
import LeftSidePanel from "../../components/admin/LeftSidePanel.vue";
import AdminNav from "../../components/admin/AdminNav.vue";
import DashboardOverview from "./DashboardOverview.vue";
export default {
  name: "Dashboard",
  components: {
    DashboardOverview,
    AdminNav,
    LeftSidePanel,
    Users,
    Books,
    Banners,
  },
  data() {
    return {
      componentsKey: null,
      isAdmin: false,
    };
  },
  computed: {
    showDashboard() {
      if (this.$route.name) {
        const adminRoute = this.$route.name === "admin";
        if (adminRoute) {
          return false;
        } else {
          return true;
        }
      }
    },
    renderComponent() {
      if (this.$route.name) {
        if (this.$route.name === "admin.users") {
          this.componentsKey = 2;
          return Users;
        } else if (this.$route.name === "admin.books") {
          this.componentsKey = 3;
          return Books;
        } else if (this.$route.name === "admin.banners") {
          this.componentsKey = 4;
          return Banners;
        }
      }
    },
  },
  async mounted() {
    console.log("hello from admin");
    const auth = await this.$store.dispatch("adminGetAuth");
    if (auth) {
      this.isAdmin = true;
    } else {
      this.$router.push("/home");
    }
  },
};
</script>
  
  <style scoped>
.Dashboard {
  min-height: 100vh;
  min-width: 100%;
  margin-top: 0px !important;
}
.Dashboard_right {
  min-height: 100vh;
}
</style>