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

    <!-- View Profile As Other Button -->
    <a
      class="px-3 py-2 hover:bg-gray-300 rounded-lg clickable decoration-none"
      :href="`/profile/${uuid}`"
    >
      View Profile As Others
    </a>
  </div>
</template>

<script>
export default {
  name: "ProfileNavigation",
  props: ["uuid"],
  data() {
    return {
      profileNavigation: [
        { key: "my-books", value: "My Books" },
        { key: "my-savedbooks", value: "My Saved Books" },
        { key: "my-reviews", value: "My Reviews" },
        { key: "my-discussions", value: "My Discussions" },
        { key: "my-comments", value: "My Comments" },
      ],
      isDropdownOpen: false,
      selectedNavigation: { key: "my-books", value: "My Books" },
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
