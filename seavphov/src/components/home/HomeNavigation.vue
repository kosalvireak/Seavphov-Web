<template>
  <section class="HomeNavigation flex flex-row h-14">
    <router-link
      v-for="tab in tabs"
      :key="tab.name"
      :to="{ name: tab.routeName }"
      :class="[
        'flex items-center clickable text-sp-primary px-3',
        { 'border-b-2 border-sp-primary': selectedTab === tab.routeName },
      ]"
    >
      <i :class="tab.iconClass" class="fa-solid fa-md mr-2"></i>
      {{ tab.name }}
    </router-link>
  </section>
</template>

<script>
export default {
  name: "HomeNavigation",
  props: {
    selectedTab: String,
  },
  data() {
    return {
      tabs: [
        {
          name: "Home",
          routeName: "home",
          iconClass: " fa-house",
        },
        {
          name: "Discussion",
          routeName: "discussion",
          iconClass: " fa-message",
        },
        {
          name: "Community",
          routeName: "search-community",
          iconClass: " fa-user-group",
        },
      ],
    };
  },
};
</script>

<style></style>
