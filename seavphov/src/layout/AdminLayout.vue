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
    <main class="admin-content bg-white">
      <AdminNavbar />
      <RouterView class="p-5" />
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
  overflow-y: auto;
}
</style>
