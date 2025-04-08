<template>
  <section class="CommunityAdmin w-100 h-100 container-xl">
    <div v-if="isCheckingPermission" class="h-96 col-span-12 flex-center">
      <Loader :size="30" />
    </div>
    <div v-else class="grid grid-cols-12 gap-8">
      <div class="col-span-12 lg:col-span-3">
        <ul class="space-y-2">
          <li
            v-for="tab in tabs"
            @click="setTab(tab.tabRoute)"
            :key="tab.name"
            :class="[
              'flex items-center clickable text-sp-primary px-3 py-2 rounded-lg hover:bg-gray-300',
              { 'bg-gray-300': currentTab === tab.tabRoute },
            ]"
          >
            <i :class="tab.iconClass" class="fa-solid fa-md mr-2"></i>
            {{ tab.name }}
          </li>
        </ul>
      </div>
      <div class="col-span-12 lg:col-span-9">
        <EditCopProfile v-if="currentTab == 'edit-profile'" :route="route" />
        <CreateReadingChallenge
          v-else-if="currentTab == 'create-challenge'"
          :route="route"
        />
      </div>
    </div>
  </section>
</template>

<script>
import CopMemberController from "../../../controllers/CopMemberController";
import CreateReadingChallenge from "../admin/CreateReadingChallenge.vue";
import EditCopProfile from "../admin/EditCopProfile.vue";
export default {
  name: "CommunityAdmin",
  components: { CreateReadingChallenge, EditCopProfile },
  data() {
    return {
      isLoading: false,
      tabs: [
        {
          name: "Edit profile",
          tabRoute: "edit-profile",
          iconClass: " fa-user-group",
        },
        {
          name: "Create challenge",
          tabRoute: "create-challenge",
          iconClass: " fa-user-group",
        },
      ],
      currentTab: "edit-profile",
      isCheckingPermission: true,
    };
  },
  watch: {
    "$route.fullPath": function () {
      this.updateTabFromHash();
    },
  },
  async mounted() {
    this.updateTabFromHash();
    // Check Permission
    await this.checkViewPermission();
    window.addEventListener("hashchange", this.updateTabFromHash);
  },
  beforeUnmount() {
    window.removeEventListener("hashchange", this.updateTabFromHash);
  },
  computed: {
    route() {
      return this.$route.params.route;
    },
  },
  methods: {
    async checkViewPermission() {
      this.isCheckingPermission = true;
      const response = await CopMemberController.checkViewCopHomePermission(
        this.route
      );

      if (!response.isCopAdmin) {
        this.toRouteName("not-found");
      } else {
        this.isCheckingPermission = false;
      }
    },
    setTab(tabName) {
      window.location.hash = `tabs=${tabName}`;
      this.currentTab = tabName;
    },
    updateTabFromHash() {
      const hash = window.location.hash;
      const match = hash.match(/tabs=([^&]+)/);
      this.currentTab = match ? match[1] : this.currentTab;
    },
  },
};
</script>

<style></style>
