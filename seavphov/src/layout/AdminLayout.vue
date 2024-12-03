<script>
import Sidebar from "../components/admin/Sidebar.vue";
import AdminNavbar from "../components/admin/AdminNavbar.vue";
import { RouterView } from "vue-router";
export default {
  name: "AdminLayout",
  components: { RouterView, Sidebar, AdminNavbar },
};
</script>

<template>
  <div class="AdminLayout w-full d-flex flex-row">
    <!-- Left Navigation -->
    <Sidebar />
    <!-- Main Content Area -->
    <main class="admin-content">
      <AdminNavbar />
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
.AdminLayout {
  height: 100vh;
}

/* Right content area */
.admin-content {
  flex: 1;
  background-color: #c1c1c1;
  color: black;
  overflow-y: auto;
}
</style>
