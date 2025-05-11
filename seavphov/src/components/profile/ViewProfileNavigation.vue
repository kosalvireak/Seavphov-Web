<template>
  <div class="container-xl flex flex-row items-center justify-between">
    <!-- Navigation Buttons for Larger Screens -->
    <div class="hidden lg:flex flex-row space-x-2">
      <div
        v-for="navigation in profileNavigation"
        :key="navigation.key"
        @click="onSelectNavigation(navigation)"
        :class="selectedNavCss(navigation.key)"
      >
        <span>{{ navigation.value }}</span>
      </div>
    </div>

    <!-- Dropdown Button for Smaller Screens -->
    <div class="lg:hidden">
      <button
        @click="toggleDropdown"
        :class="itemCss + ' ' + 'bg-sp-primary hover:bg-sp-primary text-white'"
      >
        {{ selectedNavigation.value }}
      </button>
      <!-- Dropdown Menu -->
      <div
        v-if="isDropdownOpen"
        class="absolute mt-2 w-62 bg-white shadow-lg rounded-lg z-10"
      >
        <div
          v-for="navigation in profileNavigation"
          :key="navigation.key"
          @click="onSelectNavigation(navigation)"
          :class="itemCss"
        >
          <span>{{ navigation.value }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ViewProfileNavigation",
  data() {
    return {
      profileNavigation: [
        { key: "books", value: "Books" },
        { key: "discussions", value: "Discussions" },
      ],
      isDropdownOpen: false,
      selectedNavigation: { key: "books", value: "Books" },
      itemCss: "px-3 py-2 hover:bg-gray-300 clickable rounded-lg",
    };
  },
  methods: {
    selectedNavCss(key) {
      return this.selectedNavigation.key == key
        ? "bg-sp-secondary hover:bg-sp-secondary text-white " + this.itemCss
        : this.itemCss;
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    onSelectNavigation(navigation) {
      this.isDropdownOpen = false;
      this.$emit("onSelectNavigation", navigation.key);
      this.selectedNavigation = navigation;
    },
  },
};
</script>
