<template>
  <aside
    :class="{ collapsed: isCollapsed }"
    class="side-bar-wrapper relative bg-sp-tertiary"
  >
    <nav :class="{ hidden: isCollapsed }" class="side-bar-wrapper-inner">
      <div class="flex-center w-full">
        <img
          :src="logoUrl"
          class="sp-logo-md clickable"
          alt="Seavphov Logo"
          @click="toRouteName('home')"
        />
      </div>
      <ul class="p-0 m-0">
        <li
          v-for="navigation in navigationItems"
          :key="navigation"
          :class="{ 'bg-white': currentRoute(navigation.route) }"
          class="flex align-items-center text-black hover:bg-gray-200 clickable py-3 px-4"
          @click="toRouteName(navigation.route)"
        >
          <i class="w-12 fa fa-xl" :class="navigation.icon"></i>
          <p class="m-0">{{ navigation.name }}</p>
        </li>
      </ul>
    </nav>
    <button
      @click="toggleNav"
      class="toggle-btn bg-sp-primary absolute text-center rounded-2 clickable z-40"
    >
      <span v-if="isCollapsed">→</span>
      <span v-else>←</span>
    </button>
  </aside>
</template>

<script>
export default {
  name: "Sidebar",
  data() {
    return {
      navigationItems: [
        { route: "admin.dashboard", name: "Dashboard", icon: "fa-table" },
        { route: "admin.users", name: "Users", icon: "fa-users" },
        { route: "admin.books", name: "All Books", icon: "fa-book" },
        { route: "admin.banners", name: "Banners", icon: "fa-th-large" },
      ],
      isCollapsed: false,
    };
  },
  methods: {
    toggleNav() {
      this.isCollapsed = !this.isCollapsed;
    },
    currentRoute(route) {
      return this.$route.name == route;
    },
  },
};
</script>

<style scoped>
.side-bar-wrapper {
  width: 250px;
  color: white;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  transition: width 0.3s ease; /* Smooth transition for width */
}

/* Collapsed state - shrink to 50px */
.side-bar-wrapper.collapsed {
  width: 0px;
}

/* Toggle button to collapse/expand the nav */
.toggle-btn {
  right: -55px;
  bottom: 10px;
  width: 45px;
  height: 45px;
  transition: all 0.3s ease;
}
</style>
