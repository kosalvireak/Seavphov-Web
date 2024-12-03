<template>
  <div
    class="Admin Dashboard container-xl w-100 h-100 p-0 m-0 mt-0 flex-center"
  >
    <Loader v-if="isLoading" />
    <div
      v-if="isAdmin"
      class="Dashboard container-xl w-100 h-100vh row p-0 m-0 mt-0"
    >
      <div
        class="Dashboard_left h-100vh bg-white text-black p-0"
        :class="collab"
      ></div>
      <div
        class="Dashboard_right h-100vh bg-seavphov-light m-0 p-0"
        :class="collabRight"
      >
        <AdminNav />
        <component
          :is="renderComponent"
          v-if="showDashboard"
          :key="renderComponent"
        />
        <DashboardOverview v-else />
      </div>
    </div>
  </div>
</template>
  
  <script>
import Books from "../../components/admin/Books.vue";
import Users from "../../components/admin/Users.vue";
import Banners from "../../components/admin/Banners.vue";
import AdminNav from "../../components/admin/AdminNavbar.vue";
import DashboardOverview from "./DashboardOverview.vue";
import Loader from "../../components/Loader.vue";
export default {
  name: "Dashboard",
  components: {
    DashboardOverview,
    AdminNav,
    Users,
    Books,
    Banners,
    Loader,
  },
  data() {
    return {
      isAdmin: false,
      isLoading: false,
      isCollab: false,
    };
  },
  methods: {
    collabLeftSide(param) {
      this.isCollab = param;
    },
  },
  computed: {
    collab() {
      return this.isCollab ? "col-1" : "col-2";
    },
    collabRight() {
      return this.isCollab ? "col-11" : "col-10";
    },
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
        this.isLoading = true;
        if (this.$route.name === "admin.users") {
          this.isLoading = false;
          return Users;
        } else if (this.$route.name === "admin.books") {
          this.isLoading = false;
          return Books;
        } else if (this.$route.name === "admin.banners") {
          this.isLoading = false;
          return Banners;
        }
      }
    },
  },
  async mounted() {
    this.isLoading = true;
    const auth = await this.$store.dispatch("adminGetAuth");
    if (auth) {
      this.isAdmin = true;
      this.isLoading = false;
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
  overflow: scroll;
}
</style>