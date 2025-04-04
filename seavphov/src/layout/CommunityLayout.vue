<template>
  <div class="CommunityLayout w-full h-full flex-center flex-col">
    <div class="flex-center flex-row mb-4">
      <router-link
        v-for="tab in tabs"
        :key="tab.name"
        :to="{ name: tab.routeName }"
        :class="[
          ' flex items-center clickable text-sp-primary h-14 px-3 ',
          {
            'border-b-2 border-sp-primary': currentRouteName === tab.routeName,
          },
        ]"
      >
        <i :class="tab.iconClass" class="fa-solid fa-md mr-2"></i>
        {{ tab.name }}
      </router-link>
    </div>

    <RouterView v-slot="{ Component }">
      <component :is="Component" :permissionObject="permissionObject" />
    </RouterView>
  </div>
</template>

<script>
import CopMemberController from "../controllers/CopMemberController";
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
      ],
      isLoading: false,
      permissionObject: {},
    };
  },
  computed: {
    currentRouteName() {
      return this.$route.name;
    },
  },
  async mounted() {
    this.isLoading = true;
    const response = await CopMemberController.checkViewCopHomePermission(
      this.$route.params.route
    );

    this.permissionObject = response;

    if (response.isCopAdmin) {
      this.tabs.push(
        {
          name: "Members",
          routeName: "community-members",
          iconClass: "fa-user-group",
        },
        {
          name: "Admin",
          routeName: "community-admin",
          iconClass: "fa-gear",
        }
      );
    }

    this.isLoading = false;
  },
};
</script>

<style></style>
