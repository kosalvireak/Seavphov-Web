<template>
  <div class="Dashboard container-xl w-100 h-100 row p-0 m-0">
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
      <DashboardOverviewVue v-else />
    </div>
  </div>
</template>
  
  <script>
import Books from "../../components/admin/Books.vue";
import Users from "../../components/admin/Users.vue";
import LeftSidePanel from "../../components/admin/LeftSidePanel.vue";
import AdminNav from "../../components/admin/AdminNav.vue";
import DashboardOverviewVue from "./DashboardOverview.vue";
export default {
  name: "Dashboard",
  components: { DashboardOverviewVue, AdminNav, LeftSidePanel, Users, Books },
  data() {
    return {
      componentsKey: null,
    };
  },
  computed: {
    showDashboard() {
      if (this.$route.name) {
        const adminRoute = this.$route.name === "admin";
        console.log("showDashboard", adminRoute);
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
        }
      }
    },
  },
};
</script>
  
  <style scoped>
.Dashboard {
  min-height: 100vh;
  min-width: 100%;
}
.Dashboard_right {
  min-height: 100vh;
}
</style>