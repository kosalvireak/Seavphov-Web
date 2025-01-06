<script>
import Sidebar from "../components/admin/Sidebar.vue";
import UserNavbar from "../components/UserNavbar.vue";
import { RouterView } from "vue-router";
export default {
  name: "AdminLayout",
  components: { RouterView, Sidebar, UserNavbar },
};
</script>

<template>
  <div class="AdminLayout w-full d-flex flex-row">
    <!-- Left Navigation -->
    <Sidebar class="Left-Admin-Content" />
    <!-- Main Content Area -->
    <main class="Right-Admin-Content bg-white">
      <UserNavbar />
      <RouterView class="p-5" />
    </main>
  </div>
</template>

<style scoped>
.AdminLayout {
  height: 100vh;
}

/* Right content area */
.Right-Admin-Content {
  flex: 1;
  overflow-y: auto;
}
</style>
