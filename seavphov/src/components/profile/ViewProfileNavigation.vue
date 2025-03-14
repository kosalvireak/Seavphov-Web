<template>
  <div class="container-xl flex flex-row items-start justify-between">
    <!-- Navigation Buttons for Larger Screens -->
    <div class="hidden lg:flex flex-row space-x-2">
      <div
        v-for="navigation in profileNavigation"
        :key="navigation.key"
        @click="onSelectNavigation(navigation)"
        class="p-3 hover:bg-gray-300 clickable rounded-lg"
        :class="{
          'bg-sp-secondary hover:bg-sp-secondary text-white':
            selectedNavigation.key === navigation.key,
        }"
      >
        <span>{{ navigation.value }}</span>
      </div>
    </div>

    <!-- Dropdown Button for Smaller Screens -->
    <div class="lg:hidden">
      <button
        @click="toggleDropdown"
        class="p-3 hover:bg-gray-300 rounded-lg clickable"
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
          class="p-3 hover:bg-gray-300 clickable rounded-lg"
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
    };
  },
  methods: {
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
