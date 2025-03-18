<template>
  <section class="CommunityHome container-xl grid grid-cols-12 gap-8">
    <div
      class="ProfileInfo card col-span-12 lg:col-span-3 flex flex-center py-6 space-y-2"
    >
      <div
        class="Profile hover-zoom w-24 h-24 lg:w-40 lg:h-40 flex-center rounded-full border-2 border-gray-300 overflow-hidden"
      >
        <img
          :src="community.profile"
          class="w-full h-full object-cover"
          alt="profile"
        />
      </div>

      <p class="h4 font-bold truncate-2-lines">
        {{ community.name }}
      </p>

      <p v-if="community.description" class="truncate-2-lines">
        {{ community.description }}
      </p>

      <FwbButton :color="visibilityColor" class="px-2 text-xs">{{
        visibilityText
      }}</FwbButton>

      <p>Created on: {{ formatDate(community.created_at) }}</p>
    </div>
    <div class="Content col-span-12 lg:col-span-9">
      <div class="Banner card h-64 p-2">
        <img
          :src="community.banner"
          class="w-full h-full object-center rounded-lg"
          alt="community banner"
        />
      </div>
    </div>
  </section>
</template>

<script>
import CommunityController from "../controllers/CommunityController";
export default {
  name: "CommunityHome",
  data() {
    return {
      route: this.$route.params.route,
      community: {},
    };
  },
  async mounted() {
    await this.fetchCommunity();
  },
  computed: {
    visibilityColor() {
      return this.community.private ? "red" : "green";
    },
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
  },
  methods: {
    async fetchCommunity() {
      let params = new URLSearchParams();
      params.append("route", this.route);
      this.community = await CommunityController.getCommunityByRoute(
        this.route
      );
    },
  },
};
</script>

<style>
</style>