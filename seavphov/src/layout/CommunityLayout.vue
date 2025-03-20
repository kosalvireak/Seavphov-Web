<template>
  <div class="CommunityLayout w-full h-full flex-center flex-col">
    <div v-if="isLoading" class="h-dvh flex-center">
      <Loader :size="30" />
    </div>
    <template v-else>
      <div class="flex-center flex-row mb-4">
        <router-link
          v-for="tab in tabs"
          :key="tab.name"
          :to="{ name: tab.routeName }"
          :class="[
            ' flex items-center clickable text-sp-primary h-14 px-3 ',
            {
              'border-b-2 border-sp-primary':
                currentRouteName === tab.routeName,
            },
          ]"
        >
          <i :class="tab.iconClass" class="fa-solid fa-md mr-2"></i>
          {{ tab.name }}
        </router-link>
      </div>
      <RouterView />
    </template>
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
    };
  },
  computed: {
    currentRouteName() {
      return this.$route.name;
    },
  },
  async beforeUpdate() {
    this.isLoading = true;
    const response = await CopMemberController.checkViewCopHomePermission(
      this.$route.params.route
    );

    if (response.data.isCopAdmin) {
      this.tabs.push({
        name: "Members",
        routeName: "community-members",
        iconClass: "fa-user-group",
      });
      this.tabs.push({
        name: "Settings",
        routeName: "community-settings",
        iconClass: "fa-gear",
      });
    }

    // if (!this.data.ableToViewHome) {
    //   this.$toast.info(response.message);
    //   this.toRouteName("not-found");
    // }

    this.isLoading = false;
  },
};
</script>

<style>
</style>