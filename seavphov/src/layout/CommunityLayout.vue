<template>
  <div class="CommunityLayout w-100 flex-center flex-col">
    <div class="flex-center flex-row h-14">
      <router-link
        v-for="tab in tabs"
        :key="tab.name"
        :to="{ name: tab.routeName }"
        :class="[
          ' flex items-center clickable text-sp-primary px-3',
          { 'border-b-2 border-sp-primary': selectedTab === tab.routeName },
        ]"
      >
        <i :class="tab.iconClass" class="fa-solid fa-md mr-2"></i>
        {{ tab.name }}
      </router-link>
    </div>
    <RouterView />
  </div>
</template>

<script>
export default {
  name: "CommunityLayout",
  data() {
    return {
      tabs: [
        {
          name: "Home",
          routeName: "community-home",
          iconClass: "fa-house",
        },
        {
          name: "Members",
          routeName: "community-members",
          iconClass: "fa-user-group",
        },
      ],
    };
  },
};
</script>

<style>
</style>